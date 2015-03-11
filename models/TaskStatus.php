<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "task_status".
 *
 * @property integer $status_id
 * @property integer $order_id
 * @property integer $user_id
 * @property string $status
 * @property string $datetimestamp
 *
 * @property TaskFiles $taskFiles
 * @property Users $user
 * @property PostOrder $order
 */
class TaskStatus extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'task_status';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['order_id', 'user_id', 'status', 'datetimestamp'], 'required'],
            [['order_id', 'user_id'], 'integer'],
            [['status'], 'string'],
            [['datetimestamp'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'status_id' => 'Status ID',
            'order_id' => 'Order ID',
            'user_id' => 'User ID',
            'status' => 'Status',
            'datetimestamp' => 'Datetimestamp',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTaskFiles()
    {
        return $this->hasOne(TaskFiles::className(), ['status_id' => 'status_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(Users::className(), ['user_id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrder()
    {
        return $this->hasOne(PostOrder::className(), ['order_id' => 'order_id']);
    }
}
