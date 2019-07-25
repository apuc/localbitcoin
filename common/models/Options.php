<?php

namespace common\models;

use common\classes\Debug;
use Yii;

/**
 * This is the model class for table "options".
 *
 * @property int $id
 * @property string $key
 * @property string $value
 */
class Options extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'options';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['key', 'value'], 'required'],
            [['value'], 'string'],
            [['key'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'key' => 'Key',
            'value' => 'Value',
        ];
    }

    public static function getOption($key)
    {
        $result = self::find()->where(['key' => $key])->one();
        return  $result->value ?: null;
    }

    public static function setOption($key, $value)
    {
        $option = self::find()->where(['key' => $key])->one();
        if(empty($option)){
           $option = new Options();
        }
        $option->key = $key;
        $option->value = (string) $value;
        $option->save();

        return $option;
    }
}
