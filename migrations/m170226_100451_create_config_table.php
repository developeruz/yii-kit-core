<?php

use yii\db\Migration;

/**
 * Handles the creation of table `config`.
 */
class m170226_100451_create_config_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('config', [
            'id' => $this->primaryKey(),
            'param' => \yii\db\Schema::TYPE_STRING,
            'value' => \yii\db\Schema::TYPE_STRING
        ]);

        $this->insert('config', ['param' => 'theme', 'value' => 'default']);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('config');
    }
}
