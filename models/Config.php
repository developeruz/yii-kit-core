<?php
namespace developeruz\yii_kit_core\models;

use Yii;

/**
 * This is the model class for table "config".
 *
 * @property int $id
 * @property string $param
 * @property string $value
 */
class Config extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'config';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['param', 'value'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'param' => Yii::t('app', 'Param'),
            'value' => Yii::t('app', 'Value'),
        ];
    }
}
