<?php
namespace developeruz\yii_kit_core\behaviors;

use app\components\Plugin;
use app\plugins\users\UsersPlugin;
use developeruz\yii_kit_core\assets\YiiKitAsset;
use developeruz\yii_kit_core\plugins\AdminPlugin;
use developeruz\yii_kit_core\services\ConfigService;
use yii\base\Behavior;
use yii\base\Module;
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
            Module::EVENT_BEFORE_ACTION => 'init_plugins'
        ];
    }

    public function settings()
    {
        if (\Yii::$app->db->schema->getTableSchema('config') !== null ) {

            $this->setModules();

//            \Yii::$app->attachBehavior('AccessBehavior', [
//                'class' => \developeruz\db_rbac\behaviors\AccessBehavior::className(),
//                'login_url' => '/user/security/login',
//                'protect' => ['admin']
//            ]);

            //todo: custom event для плагинов, чтобы можно было добавлять protected директории
//            \Yii::$app->behaviors['AccessBehavior']->protect = array_merge(\Yii::$app->behaviors['AccessBehavior']->protect, []);

            \Yii::$app->urlManager->addRules([
                'admin' => 'admin/admin/index'
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
                //todo: переопределение view для сторонних модулей
            }

            \Yii::$app->view->on(View::EVENT_BEFORE_RENDER, function ($event) {
                \Yii::$app->getView()->registerAssetBundle(YiiKitAsset::className());
                \Yii::setAlias('@yii_kit_theme',
                    \Yii::$app->view->assetBundles['developeruz\yii_kit_core\assets\YiiKitAsset']->baseUrl);
            });
        }

        /*
        //установка языка
        \Yii::$app->language = 'ru-RU';

        //регистрация компонента
        \Yii::$app->set('cache', [
            'class' => 'yii\caching\FileCache'
        ]);
        */
    }

    public function init_plugins()
    {
        //list all plugins and run init() for all of them

        $plugin = new Plugin();
        $plugin->init();

        $plugin = new UsersPlugin();
        $plugin->init();

        //init core admin plugin
        $plugin = new AdminPlugin();
        $plugin->init();



    }

    private function setModules()
    {
        \Yii::$app->setModule('admin', [
            'class' => 'developeruz\yii_kit_core\Module',
        ]);
        \Yii::$app->behaviors['AccessBehavior']->protect = array_merge(\Yii::$app->behaviors['AccessBehavior']->protect,
            ['permit']);

        \Yii::$app->setModule('permit', [
            'class' => 'developeruz\db_rbac\Yii2DbRbac',
            'layout' => '@vendor/developeruz/yii-kit-core/views/layouts/main',
            'params' => [
                'userClass' => 'app\models\User'
            ]
        ]);

        \Yii::$app->setModule('comment', [
            'class' => 'yii2mod\comments\Module'
        ]);
    }
}
