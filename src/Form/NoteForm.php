<?php
namespace Adx\Module\NoteModule\Form;

use yii\base\Model;
use yii\helpers\StringHelper;

/**
 * Create or update note form.
 */
class NoteForm extends Model
{
    public $title;
    public $note;

    /**
     * @inheritdoc
     */
    public function formName()
    {
        return '';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title'], 'required'],
            [['note'], 'string'],

            // filters
            [['title', 'note'], 'trim'],
            [['title'] , 'filter', 'filter' => function ($attribute) {
                return StringHelper::truncate($attribute, 255, false);
            }],
        ];
    }

    /**
     * Form validation
     *
     * @return boolean
     */
    public function isValid()
    {
        return $this->validate();
    }
}
