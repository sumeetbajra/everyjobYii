<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "notification".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $notification
 * @property string $datetimestamp
 * @property integer $read
 * @property integer $source
 */
class Notification extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'notification';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'notification', 'datetimestamp', 'source'], 'required'],
            [['user_id', 'read', 'source'], 'integer'],
            [['datetimestamp'], 'safe'],
            [['notification'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'notification' => 'Notification',
            'datetimestamp' => 'Datetimestamp',
            'read' => 'Read',
            'source' => 'Source',
        ];
    }
}
