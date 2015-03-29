<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "withdraw_transaction".
 *
 * @property string $transaction_id
 * @property integer $user_id
 * @property string $request_date
 * @property integer $complete
 * @property string $datetimestamp
 */
class WithdrawTransaction extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'withdraw_transaction';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['transaction_id', 'user_id', 'request_date', 'withdraw_id'], 'required'],
            [['user_id', 'complete'], 'integer'],
            [['request_date', 'datetimestamp'], 'safe'],
            [['transaction_id'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'transaction_id' => 'Transaction ID',
            'user_id' => 'User ID',
            'request_date' => 'Request Date',
            'complete' => 'Complete',
            'datetimestamp' => 'Datetimestamp',
            'withdraw_id' => 'Withdraw Id',
        ];
    }
}
