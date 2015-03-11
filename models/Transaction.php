<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "transaction".
 *
 * @property string $transaction_id
 * @property integer $order_id
 * @property integer $post_id
 * @property string $post_price
 * @property string $currency
 * @property string $amount
 * @property string $payment_status
 * @property string $payer_email
 * @property string $datetimestamp
 * @property string $error_log
 */
class Transaction extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'transaction';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['transaction_id', 'order_id', 'post_id', 'post_price', 'currency', 'amount', 'payment_status', 'payer_email', 'datetimestamp'], 'required'],
            [['order_id', 'post_id'], 'integer'],
            [['post_price', 'amount'], 'number'],
            [['datetimestamp'], 'safe'],
            [['error_log'], 'string'],
            [['transaction_id'], 'string', 'max' => 255],
            [['currency'], 'string', 'max' => 10],
            [['payment_status', 'payer_email'], 'string', 'max' => 100]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'transaction_id' => 'Transaction ID',
            'order_id' => 'Order ID',
            'post_id' => 'Post ID',
            'post_price' => 'Post Price',
            'currency' => 'Currency',
            'amount' => 'Amount',
            'payment_status' => 'Payment Status',
            'payer_email' => 'Payer Email',
            'datetimestamp' => 'Datetimestamp',
            'error_log' => 'Error Log',
        ];
    }
}
