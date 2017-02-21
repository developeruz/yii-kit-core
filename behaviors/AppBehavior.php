<?php
namespace developeruz\yii_kit_core\behaviors;

use yii\base\Behavior;
use yii\base\Theme;
use yii\web\Application;

class AppBehavior extends Behavior
{
    public function events()
    {
        return [
            Application::EVENT_BEFORE_REQUEST => 'settings',
        ];
    }

    public function settings()
    {
        \Yii::$app->setModule('admin', [
            'class' => 'developeruz\yii_kit_core\Module',
        ]);

        if (env('ADMIN_THEME_PATH')) {
            \Yii::$app->view->theme = new Theme(
                [
                    'pathMap' => [
                        '@vendor/developeruz/yii-kit-core/views' => env('ADMIN_THEME_PATH')
                    ]
                ]
            );
        }

        /*
        //установка языка
        \Yii::$app->language = 'ru-RU';

        //добавление правил роутинга
        \Yii::$app->urlManager->addRules(['test' => 'site/index']);

        //регистрация модуля
        \Yii::$app->setModule('new', [
            'class' => 'yii\gii\Module'
        ]);

        //регистрация компонента
        \Yii::$app->set('cache', [
            'class' => 'yii\caching\FileCache'
        ]);
        */
    }

}
