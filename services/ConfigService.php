<?php
namespace developeruz\yii_kit_core\services;

use developeruz\yii_kit_core\repositories\ConfigRepository;

class ConfigService
{
    private $configRepository;

    public function __construct(ConfigRepository $configRepository)
    {
        $this->configRepository = $configRepository;
    }

    public function getActiveTheme()
    {
        $theme = $this->configRepository->getActiveTheme();
        return $theme->value;
    }

    public function getAllThemes()
    {
        $themes = array_diff( scandir(\Yii::getAlias('@app').'/themes'), ['.', '..']);
        $themes[] = 'default';
        return $themes;
    }

    public function activateTheme($theme)
    {
        return $this->configRepository->setActiveTheme($theme);
    }

}
