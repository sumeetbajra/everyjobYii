<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "error".
 *
 * @property integer $id
 * @property string $log
 */
class Error extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'error';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['log'], 'required'],
            [['log'], 'string']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'log' => 'Log',
        ];
    }
}
