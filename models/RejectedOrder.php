<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "rejected_order".
 *
 * @property integer $order_id
 * @property string $reason
 * @property string $datetimestamp
 */
class RejectedOrder extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'rejected_order';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['order_id', 'reason', 'datetimestamp'], 'required'],
            [['order_id'], 'integer'],
            [['reason'], 'string'],
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
            'reason' => 'Reason',
            'datetimestamp' => 'Datetimestamp',
        ];
    }
}
