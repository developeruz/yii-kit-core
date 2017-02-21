<?php
namespace developeruz\yii_kit_core;

use app\components\Plugin;

class Module extends \yii\base\Module
{
    public $layout = 'main';

    public $topMenuItems = [];

    public function beforeAction($action)
    {
        //list all plugins and run init() for all of them

        $plugin = new Plugin();
        $plugin->init();
        return parent::beforeAction($action);
    }

}
