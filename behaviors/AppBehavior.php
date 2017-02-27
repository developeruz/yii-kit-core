<?php
namespace developeruz\yii_kit_core\behaviors;

use developeruz\yii_kit_core\assets\YiiKitAsset;
use developeruz\yii_kit_core\services\ConfigService;
use yii\base\Behavior;
use yii\base\Theme;
use yii\web\Application;
use yii\web\View;

class AppBehavior extends Behavior
{
    public $configService;

    public function __construct(array $config = [], ConfigService $configService)
    {
        $this->configService = $configService;
        parent::__construct($config);
    }

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

        \Yii::$app->urlManager->addRules([
            'admin' => 'admin/admin/index',
            'admin/index' => 'admin/admin/index',
        ]);

        $theme = $this->configService->getActiveTheme();
        if ($theme != 'default') {
            \Yii::$app->view->theme = new Theme(
                [
                    'pathMap' => [
                        '@app/views' => '@app/themes/' . $theme,
                        '@vendor/developeruz/yii-kit-core/views' => '@app/themes/' . $theme . '/modules/admin'
                    ]
                ]
            );
        }

        \Yii::$app->view->on(View::EVENT_BEFORE_RENDER, function ($event) {
            \Yii::$app->getView()->registerAssetBundle(YiiKitAsset::className());
            \Yii::setAlias('@yii_kit_theme',
                \Yii::$app->view->assetBundles['developeruz\yii_kit_core\assets\YiiKitAsset']->baseUrl);
        });

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
