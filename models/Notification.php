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
 * @property string $type
 * @property integer $post_id
 * @property integer $status
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
            [['user_id', 'notification', 'datetimestamp', 'source', 'type', 'post_id'], 'required'],
            [['user_id', 'read', 'source', 'post_id', 'status'], 'integer'],
            [['datetimestamp'], 'safe'],
            [['notification'], 'string', 'max' => 255],
            [['type'], 'string', 'max' => 50]
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
            'type' => 'Type',
            'post_id' => 'Post ID',
            'status' => 'Status',
        ];
    }
}
