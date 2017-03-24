<?php
namespace developeruz\yii_kit_core\repositories;

use developeruz\yii_kit_core\models\Plugins;
use yii\db\Expression;

class PluginRepository
{
    private $model;

    public function __construct(Plugins $plugins)
    {
        $this->model = $plugins;
    }

    public function getInstalled()
    {
        $result = [];
        $rows = $this->model->find()->orderBy('order')->all();
        foreach($rows as $row) {
            $result[$row['name']] = $row;
        }
        return $result;
    }

    public function install($folder)
    {
        $this->model->name = $folder;
        $this->model->order = 0;
        return $this->model->save();
    }

    public function uninstall($folder)
    {
        return $this->model->find()->where(['name' => $folder])->one()->delete();
    }

    public function up($folder)
    {
        return $this->model->updateAll(['order' => new Expression('`order` + 1')], ['name' => $folder]);
    }

    public function down($folder)
    {
        return $this->model->updateAll(['order' => new Expression('`order` - 1')], ['name' => $folder]);
    }
}
