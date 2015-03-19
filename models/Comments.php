<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "comments".
 *
 * @property integer $comment_id
 * @property string $comment
 * @property integer $user_id
 * @property integer $comment_by
 * @property integer $stars
 * @property string $datetimestamp
 * @property integer $status
 *
 * @property Users $commentBy
 */
class Comments extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'comments';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'comment_by', 'stars', 'datetimestamp'], 'required'],
            [['user_id', 'comment_by', 'stars', 'status'], 'integer'],
            [['datetimestamp'], 'safe'],
            [['comment'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'comment_id' => 'Comment ID',
            'comment' => 'Comment',
            'user_id' => 'User ID',
            'comment_by' => 'Comment By',
            'stars' => 'Stars',
            'datetimestamp' => 'Datetimestamp',
            'status' => 'Status',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCommentBy()
    {
        return $this->hasOne(Users::className(), ['user_id' => 'comment_by']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(Users::className(), ['user_id' => 'user_id']);
    }
}
