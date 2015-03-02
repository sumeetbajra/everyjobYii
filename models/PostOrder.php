<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "post_order".
 *
 * @property integer $order_id
 * @property integer $post_id
 * @property integer $user_id
 * @property string $details
 * @property integer $status
 * @property string $datetimestamp
 */
class PostOrder extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'post_order';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['post_id', 'user_id', 'details', 'status', 'datetimestamp'], 'required'],
            [['post_id', 'user_id', 'status'], 'integer'],
            [['details'], 'string'],
            [['datetimestamp'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'order_id' => 'Order ID',
            'post_id' => 'Post ID',
            'user_id' => 'User ID',
            'details' => 'Details',
            'status' => 'Status',
            'datetimestamp' => 'Datetimestamp',
        ];
    }

    public function getRejected(){
        return $this->hasOne(RejectedOrder::className(), ['order_id'=>'order_id']);
    }

      public function getPost(){
        return $this->hasOne(PostServices::className(), ['post_id'=>'post_id']);
    }

    public function getAccepted(){
        return $this->hasOne(AcceptedOrders::className(), ['post_id'=>'post_id']);
    }
}
