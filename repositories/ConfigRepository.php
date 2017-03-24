<?php
namespace developeruz\yii_kit_core\repositories;

use developeruz\yii_kit_core\models\Config;

class ConfigRepository
{
    private $model;

    public function __construct(Config $config)
    {
        $this->model = $config;
    }

    public function getActiveTheme()
    {
        return $this->model->find()->where(['param' => 'theme'])->one();
    }

    public function setActiveTheme($theme)
    {
        $themeConfig = $this->getActiveTheme();
        $themeConfig->value = $theme;
        return $themeConfig->save();
    }
}
