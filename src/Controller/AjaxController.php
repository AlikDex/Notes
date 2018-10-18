<?php
namespace Adx\Module\NoteModule\Controller;

use Yii;
use yii\web\Controller;
use yii\base\DynamicModel;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use Adx\Module\NoteModule\Model\Note;
use Adx\Module\NoteModule\Form\NoteForm;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * AjaxController implements the CRUD actions for Note model from ajax.
 */
class AjaxController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
           'access' => [
               'class' => AccessControl::class,
               'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'view' => ['get'],
                    'delete' => ['post'],
                    'save-order' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function beforeAction($action)
    {
        $this->enableCsrfValidation = false;

        return parent::beforeAction($action);
    }

    /**
     * Displays a single Note model.
     *
     * @param integer $id
     *
     * @return mixed
     */
    public function actionView($id)
    {
        try {
            $note = $this->findById($id);

            return $this->asJson([
                'note' => $note,
            ]);
        } catch (NotFoundHttpException $e) {
            return $this->asJson([
                'error' => [
                    'code' => 404,
                    'message' => $e->getMessage(),
                ],
            ]);
        }
    }

    /**
     * Displays a information about Note.
     *
     * @param integer $id
     *
     * @return mixed
     */
    public function actionInfo($id)
    {
        $note = $this->findById($id);

        return $this->render('info', [
            'note' => $note,
        ]);
    }

    /**
     * Add new Note model.
     * If update is successful, the browser will be redirected to the 'view' page.
     *
     * @param integer $id
     *
     * @return mixed
     */
    public function actionCreate()
    {
        $form = new NoteForm;

        if ($form->load(Yii::$app->request->post()) && $form->isValid()) {
            $note = new Note;
            $note->setAttributes($form->getAttributes());
            $note->user_id = Yii::$app->user->getId();
            $note->updated_at = gmdate('Y-m-d H:i:s');
            $note->created_at = gmdate('Y-m-d H:i:s');

            if ($note->save()) {
                Yii::$app->session->setFlash('success', Yii::t('note', 'New note "<b>{title}</b>" created', ['title' => $note->title]));

                $this->redirect(['view', 'id' => $note->getId()]);
            } else {
                Yii::$app->session->setFlash('error', 'Validation fail');
            }
        }

        return $this->render('create', [
            'form' => $form,
        ]);
    }

    /**
     * Updates an existing Note model.
     * If update is successful, the browser will be redirected to the 'view' page.
     *
     * @param integer $id
     *
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $note = $this->findById($id);

        $form = new NoteForm;
        $form->setAttributes($note->getAttributes());

        if ($form->load(Yii::$app->request->post()) && $form->isValid()) {
            $note->setAttributes($form->getAttributes());
            $note->updated_at = gmdate('Y-m-d H:i:s');

            if ($note->save()) {
                Yii::$app->session->setFlash('success', Yii::t('note', 'Note "<b>{title}</b>" updated', ['title' => $note->title]));

                $this->redirect(['view', 'id' => $note->getId()]);
            } else {
                Yii::$app->session->setFlash('error', 'Validation fail');
            }
        }

        return $this->render('update', [
            'note' => $note,
            'form' => $form,
        ]);
    }

    /**
     * Deletes an existing Note model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     *
     * @param integer $id
     *
     * @return mixed
     */
    public function actionDelete($id)
    {
        $note = $this->findById($id);

        if ($note->delete()) {
            Yii::$app->session->setFlash('success', Yii::t('project', 'Note "<b>{$title}</b>" deleted', ['title' => $note->title]));
        } else {
            Yii::$app->session->setFlash('error', Yii::t('project', 'Note "<b>{$title}</b>" deletion fail', ['title' => $note->title]));
        }

        return $this->redirect(['index']);
    }

    /**
     * Сохраняет порядок сортировки записок, установленный пользователем.
     *
     * @return mixed
     */
    public function actionSaveOrder()
    {
            // Валидация массива идентификаторов записок.
        $validationModel = DynamicModel::validateData(['note_ids' => Yii::$app->request->post('order')], [
            ['note_ids', 'each', 'rule' => ['integer']],
            ['note_ids', 'filter', 'filter' => 'array_filter'],
            ['note_ids', 'required', 'message' => 'Notes is empty'],
        ]);

        if ($validationModel->hasErrors()) {
            return $this->asJson([
                'error' => [
                    'code' => 1,
                    'message' => 'Validation fail',
                ],
            ]);
        }

        $db = Yii::$app->db;
        $transaction = $db->beginTransaction();

        try {
            Note::updateAll([
                '{{order}}' => new \yii\db\Expression("FIND_IN_SET(`note_id`, :id_list)"),
            ], [
                'AND',
                ['!=', new \yii\db\Expression("FIND_IN_SET(`note_id`, :id_list)"), 0],
                ['{{user_id}}' => Yii::$app->user->getId()],
            ], [
                ':id_list' => \implode(',', $validationModel->note_ids),
            ]);

            $transaction->commit();

            return $this->asJson([
                'message' => 'Order saved'
            ]);
        } catch (\Exception $e) {
            $transaction->rollBack();

            return $this->asJson([
                'error' => [
                    'code' => 422,
                    'message' => $e->getMessage(),
                ],
            ]);
        }
    }

    /**
     * Поиск записки по ее идентификатору
     *
     * @param integer $id Идентификатор записки.
     *
     * @return mixed
     *
     * @throw NotFoundHttpException Если записка не найдена.
     */
    protected function findById($id)
    {
        $note = Note::find()
            ->where(['note_id' => $id, 'user_id' => Yii::$app->user->getId()])
            ->one();

        if (null === $note) {
            throw new NotFoundHttpException('The requested note does not exist.');
        }

        return $note;
    }
}
