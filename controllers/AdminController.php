<?php
namespace developeruz\yii_kit_core\controllers;

use Yii;
use yii\web\Controller;

class AdminController extends Controller
{

    public function actionIndex()
    {
        return $this->render('index');
    }
}
