<?php
namespace Adx\Module\NoteModule\Model;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "project_images".
 *
 * @property integer $note_id
 * @property integer $user_id
 * @property integer $order
 * @property string $title
 * @property string $note
 * @property string $updated_at
 * @property string $created_at
 */
class Note extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'notes';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title'], 'required'],
            [['user_id', 'order'], 'integer'],
            [['title', 'note'], 'string'],
            [['updated_at', 'created_at'], 'safe'],
        ];
    }

    public function getId()
    {
        return $this->note_id;
    }
}
