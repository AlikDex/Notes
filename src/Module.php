<?php
namespace Adx\Module\NoteModule;

use Yii;
use yii\base\Module as BaseModule;
use yii\i18n\PhpMessageSource;
use yii\console\Application as ConsoleApplication;
use yii\web\Application as WebApplication;

/**
 * This is the main module class of the video extension.
 */
class Module extends BaseModule
{
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'Adx\Module\NoteModule';
    /**
     * @inheritdoc
     */
    public $defaultRoute = 'main/index';

    /**
     * @inheritdoc
     */
    public function __construct($id, $parent = null, $config = [])
    {
        // дефолтный путь до папки темплейтов.
        $this->viewPath = __DIR__ . '/Resources/views';

        parent::__construct ($id, $parent, $config);
    }

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        // контреллеры для консольных команд
        if (Yii::$app instanceof ConsoleApplication) {
            $this->controllerNamespace = 'Adx\Module\NoteModule\Command';
        }

        // перевод
        if (Yii::$app->has('i18n') && !isset(Yii::$app->get('i18n')->translations['note'])) {
            Yii::$app->get('i18n')->translations['note'] = [
                'class' => PhpMessageSource::class,
                'basePath' => __DIR__ . '/Resources/i18n',
                'sourceLanguage' => 'en-US',
            ];
        }
    }
}
