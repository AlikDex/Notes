<?php
namespace Adx\Module\NoteModule\Widget;

use Yii;
use yii\base\Widget;
use yii\web\IdentityInterface;
use yii\data\ActiveDataProvider;
use Adx\Module\NoteModule\Model\Note;


class NoteList extends Widget
{
    protected $user;

    /**
     * Returns the directory containing the view files for this widget.
     * The default implementation returns the 'views' subdirectory under the directory containing the widget class file.
     * @return string the directory containing the view files for this widget.
     */
    public function getViewPath()
    {
        $parentDir = dirname(__DIR__);

        return \realpath("{$parentDir}/Resources/views/widgets");
    }

    public function init()
    {
        parent::init();

        //$this->user = Yii::$container->get(IdentityInterface::class);
    }

    /**
     * Execute widget
     *
     * @return void
     */
    public function run()
    {
        $query = Note::find()
            ->where(['{{user_id}}' => Yii::$app->user->getId()])
            ->orderBy(['{{order}}' => SORT_ASC]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        return $this->render('note-list', [
            'dataProvider' => $dataProvider,
        ]);
    }
}
