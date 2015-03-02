<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "transaction".
 *
 * @property string $transaction_id
 * @property integer $post_id
 * @property string $price
 * @property string $currency
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
            [['transaction_id', 'post_id', 'price', 'currency', 'payment_status', 'payer_email', 'datetimestamp'], 'required'],
            [['post_id'], 'integer'],
            [['price'], 'number'],
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
            'post_id' => 'Post ID',
            'price' => 'Price',
            'currency' => 'Currency',
            'payment_status' => 'Payment Status',
            'payer_email' => 'Payer Email',
            'datetimestamp' => 'Datetimestamp',
            'error_log' => 'Error Log',
        ];
    }
}
