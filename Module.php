<?php
namespace developeruz\yii_kit_core;

use app\components\Plugin;
use developeruz\yii_kit_core\plugins\AdminPlugin;

class Module extends \yii\base\Module
{
    public $layout = 'main';

    public function beforeAction($action)
    {
        //init core admin plugin
        $plugin = new AdminPlugin();
        $plugin->init();

        //list all plugins and run init() for all of them

        $plugin = new Plugin();
        $plugin->init();

        return parent::beforeAction($action);
    }

}
