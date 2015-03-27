<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "message".
 *
 * @property integer $message_id
 * @property string $subject
 * @property string $message
 * @property integer $from_user
 * @property integer $to_user
 * @property integer $thread_id
 * @property string $datetimestamp
 * @property integer $read_m
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
            [['message', 'from_user', 'to_user', 'datetimestamp'], 'required'],
            [['message'], 'string'],
            [['from_user', 'to_user', 'thread_id', 'read_m', 'status'], 'integer'],
            [['datetimestamp'], 'safe'],
            [['subject'], 'string', 'max' => 30],
            [['captcha'], 'captcha', 'on'=>'nonadmin'],
            [['captcha'], 'required', 'on'=>'nonadmin'],
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
            'from_user' => 'From User',
            'to_user' => 'To User',
            'thread_id' => 'Thread ID',
            'datetimestamp' => 'Datetimestamp',
            'read_m' => 'Read M',
            'status' => 'Status',
        ];
    }

    /**
 * Get excerpt from string
 * 
 * @param String $str String to get an excerpt from
 * @param Integer $startPos Position int string to start excerpt from
 * @param Integer $maxLength Maximum length the excerpt may be
 * @return String excerpt
 */
function getExcerpt($str, $startPos=0, $maxLength=30) {
    if(strlen($str) > $maxLength) {
        $excerpt   = substr($str, $startPos, $maxLength-3);
        $lastSpace = strrpos($excerpt, ' ');
        $excerpt   = substr($excerpt, 0, $lastSpace);
        $excerpt  .= '...';
    } else {
        $excerpt = $str;
    }
    
    return $excerpt;
}

public function getModels(){
    return $this;
}

}
