<?php
namespace developeruz\yii_kit_core\services;

use developeruz\yii_kit_core\repositories\PluginRepository;
use developeruz\yii_kit_core\base\Plugin;

class PluginService
{
    private $pluginRepository;

    public function __construct(PluginRepository $pluginRepository)
    {
        $this->pluginRepository = $pluginRepository;
    }

    public function listPlugins()
    {
        $plugins = [];
        $folders = $this->getAllFromFolder();
        $installed = $this->pluginRepository->getInstalled();
        foreach ($folders as $folder) {
            $plugins[] = [
                'folder' => $folder,
                'description' => $this->getDescription($folder),
                'is_plugin' => $this->checkIsPlugin($folder),
                'is_installed' => $this->checkIsInstalled($folder, $installed),
                'priority' => $this->getOrder($folder, $installed)
            ];
        }
        return $plugins;
    }

    public function install($folder)
    {
        $installed = $this->pluginRepository->getInstalled();
        if (!$this->checkIsInstalled($folder, $installed)) {
            $this->pluginRepository->install($folder);
            return $this->getInstallInstruction($folder);
        } else {
            return \Yii::t('app', 'Plugin is already installed');
        }
    }

    public function uninstall($folder)
    {
        $installed = $this->pluginRepository->getInstalled();
        if ($this->checkIsInstalled($folder, $installed)) {
            $this->pluginRepository->uninstall($folder);
            return $this->getUninstallInstruction($folder);
        } else {
            return \Yii::t('app', 'Plugin is not installed');
        }
    }

    public function up($folder)
    {
        $this->pluginRepository->up($folder);
    }

    public function down($folder)
    {
        $this->pluginRepository->down($folder);
    }

    private function getAllFromFolder()
    {
        return array_diff(scandir(\Yii::getAlias('@app') . '/plugins'), ['.', '..']);
    }

    private function checkIsPlugin($folder)
    {
        $pluginClassName = 'app\plugins\users\\' . ucwords($folder) . 'Plugin';
        return
            class_exists('app\plugins\users\\' . ucwords($folder) . 'Plugin') &&
            in_array('developeruz\yii_kit_core\base\Plugin', class_parents($pluginClassName));
    }

    private function checkIsInstalled($folder, $all)
    {
        return array_key_exists($folder, $all);
    }

    private function getOrder($folder, $all)
    {
        if($this->checkIsInstalled($folder, $all)) {
            return $all[$folder]->order;
        }
        return 0;
    }

    private function getDescription($folder)
    {
        if ($this->checkIsPlugin($folder)) {
            $class = '\app\plugins\users\\' . ucwords($folder) . 'Plugin';
            if (method_exists($class, 'info')) {
                return $class::info();
            } else {
                Plugin::info();
            }
        } else {
            return \Yii::t('app', 'Error: Plugin is broken');
        }
    }

    private function getInstallInstruction($folder)
    {
        if ($this->checkIsPlugin($folder)) {
            $class = '\app\plugins\users\\' . ucwords($folder) . 'Plugin';
            if (method_exists($class, 'install')) {
                return $class::install();
            } else {
                return Plugin::install();
            }
        } else {
            return \Yii::t('app', 'Error: Plugin is broken');
        }
    }

    private function getUninstallInstruction($folder)
    {
        if ($this->checkIsPlugin($folder)) {
            $class = '\app\plugins\users\\' . ucwords($folder) . 'Plugin';
            if (method_exists($class, 'uninstall')) {
                return $class::uninstall();
            } else {
                return Plugin::uninstall();
            }
        } else {
            return \Yii::t('app', 'Error: Plugin is broken');
        }
    }
}
