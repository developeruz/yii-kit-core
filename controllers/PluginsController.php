<?php
namespace developeruz\yii_kit_core\controllers;

use developeruz\yii_kit_core\services\PluginService;
use Yii;
use yii\base\Module;
use yii\data\ArrayDataProvider;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\Request;

class PluginsController extends Controller
{
    private $pluginService;

    public function __construct($id, Module $module, array $config = [], PluginService $pluginService)
    {
        parent::__construct($id, $module, $config);
        $this->pluginService = $pluginService;
    }

    public function actionIndex()
    {
        $plugins = $this->pluginService->listPlugins();
        $plugins = new ArrayDataProvider([
           'allModels' => $plugins,
           'sort' => [
               'attributes' => ['folder', 'is_plugin', 'is_installed', 'priority'],
               'defaultOrder' => ['priority' => SORT_DESC]
           ],
        ]);
        return $this->render('index', compact('plugins'));
    }

    public function actionInstall()
    {
        $folder = Yii::$app->request->get('folder');
        $result = $this->pluginService->install($folder);
        return $this->render('install', compact('result'));
    }

    public function actionUninstall()
    {
        $folder = Yii::$app->request->get('folder');
        $result = $this->pluginService->uninstall($folder);
        return $this->render('install', compact('result'));
    }

    public function actionUp()
    {
        $folder = Yii::$app->request->get('folder');
        $this->pluginService->up($folder);
        return $this->redirect(Url::to('/admin/plugins'));
    }

    public function actionDown()
    {
        $folder = Yii::$app->request->get('folder');
        $this->pluginService->down($folder);
        return $this->redirect(Url::to('/admin/plugins'));
    }
}
