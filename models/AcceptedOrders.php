<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "accepted_orders".
 *
 * @property integer $order_id
 * @property string $datetimestamp
 * @property integer $post_id
 * @property integer $user_id
 * @property string $payment
 * @property string $delivery_date
 * @property integer $complete_request
 * @property string $complete_request_date
 * @property integer $cancel_request
 * @property string $cancel_request_date
 * @property string $closed_date
 */
class AcceptedOrders extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
      return 'accepted_orders';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
      return [
      [['order_id', 'datetimestamp', 'post_id', 'user_id'], 'required'],
      [['order_id', 'post_id', 'user_id', 'complete_request', 'cancel_request'], 'integer'],
      [['datetimestamp', 'delivery_date', 'complete_request_date', 'cancel_request_date', 'closed_date'], 'safe'],
      [['payment'], 'string', 'max' => 20]
      ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
      return [
      'order_id' => 'Order ID',
      'datetimestamp' => 'Datetimestamp',
      'post_id' => 'Post ID',
      'user_id' => 'User ID',
      'payment' => 'Payment',
      'delivery_date' => 'Delivery Date',
      'complete_request' => 'Complete Request',
      'complete_request_date' => 'Complete Request Date',
      'cancel_request' => 'Cancel Request',
      'cancel_request_date' => 'Cancel Request Date',
      'closed_date' => 'Closed Date',
      ];
    }

    public function getPosts(){
      return $this->hasOne(PostServices::className(), ['post_id'=>'post_id']);
    }

    public function getOrder(){
      return $this->hasOne(PostOrder::className(), ['order_id'=>'order_id']);
    }
  }
