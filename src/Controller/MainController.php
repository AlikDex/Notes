<?php
namespace Adx\Module\NoteModule\Controller;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * ProjectController implements the CRUD actions for Project model.
 */
class MainController extends Controller
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
                    'delete' => ['post'],
                    'delete-image' => ['post'],
                    'save-order' => ['post'],
                    'set-cover-image' => ['post'],
                    'image-toggle-enabled' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all Project models.
     * @return mixed
     */
    public function actionIndex()
    {
        return $this->render('index', []);
    }

}
