<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "message".
 *
 * @property integer $message_id
 * @property string $subject
 * @property string $message
 * @property integer $from
 * @property integer $to
 * @property string $datetimestamp
 * @property integer $read
 * @property integer $status
 */
class Message extends \yii\db\ActiveRecord
{
    public $captcha;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'message';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['captcha'], 'captcha'],
            [['captcha'], 'required'],
            [['message', 'from', 'to', 'datetimestamp'], 'required'],
            [['message'], 'string'],
            [['from', 'to', 'read', 'status'], 'integer'],
            [['datetimestamp'], 'safe'],
            [['subject'], 'string', 'max' => 30]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'message_id' => 'Message ID',
            'subject' => 'Subject',
            'message' => 'Message',
            'from' => 'From',
            'to' => 'To',
            'datetimestamp' => 'Datetimestamp',
            'read' => 'Read',
            'status' => 'Status',
        ];
    }
}
