<?php
namespace developeruz\yii_kit_core\controllers;

use developeruz\yii_kit_core\services\ConfigService;
use Yii;
use yii\base\Module;
use yii\filters\VerbFilter;
use yii\web\Controller;

class SettingsController extends Controller
{
    private $configService;

    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'set-theme' => ['post'],
                ],
            ],
        ];
    }

    public function __construct($id, Module $module, array $config = [], ConfigService $configService)
    {
        parent::__construct($id, $module, $config);
        $this->configService = $configService;
    }

    public function actionIndex()
    {
        $themes = $this->configService->getAllThemes();
        $activeTheme = $this->configService->getActiveTheme();
        return $this->render('index', compact('themes', 'activeTheme'));
    }

    public function actionSetTheme()
    {
        $theme = Yii::$app->request->post('theme');
        $this->configService->activateTheme($theme);
        return $this->redirect(['/admin/settings']);
    }

    public function actionFlushCache()
    {
        Yii::$app->cache->flush();
        Yii::$app->getSession()->setFlash('success', Yii::t('app', 'Cache flushed'));
        return $this->redirect(['/admin/settings']);
    }

    public function actionClearAssets()
    {
        foreach(glob(Yii::$app->assetManager->basePath . DIRECTORY_SEPARATOR . '*') as $asset){
            if(is_link($asset)){
                unlink($asset);
            } elseif(is_dir($asset)){
                $this->deleteDir($asset);
            } else {
                unlink($asset);
            }
        }
        Yii::$app->getSession()->setFlash('success', Yii::t('app', 'Assets cleared'));
        return $this->redirect(['/admin/settings']);
    }

    private function deleteDir($directory)
    {
        $iterator = new \RecursiveDirectoryIterator($directory, \RecursiveDirectoryIterator::SKIP_DOTS);
        $files = new \RecursiveIteratorIterator($iterator, \RecursiveIteratorIterator::CHILD_FIRST);
        foreach($files as $file) {
            if ($file->isDir()){
                rmdir($file->getRealPath());
            } else {
                unlink($file->getRealPath());
            }
        }
        return rmdir($directory);
    }
}
