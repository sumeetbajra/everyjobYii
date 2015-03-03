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
 * @property string $status
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
            [['order_id', 'post_id', 'user_id'], 'integer'],
            [['datetimestamp'], 'safe'],
            [['status'], 'string', 'max' => 20]
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
            'status' => 'Status',
        ];
    }
}
