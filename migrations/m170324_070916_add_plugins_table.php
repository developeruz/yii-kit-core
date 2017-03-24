<?php

use yii\db\Migration;

class m170324_070916_add_plugins_table extends Migration
{
    public function up()
    {
        $this->createTable('plugins', [
            'id' => $this->primaryKey(),
            'name' => \yii\db\Schema::TYPE_STRING,
            'order' => \yii\db\Schema::TYPE_SMALLINT
        ]);
    }

    public function down()
    {
        return $this->dropTable('plugins');
    }
}
