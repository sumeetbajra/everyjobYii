<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "post_ratings".
 *
 * @property integer $id
 * @property integer $post_id
 * @property integer $rating
 * @property integer $user_id
 * @property string $datetimestamp
 */
class PostRatings extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'post_ratings';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['post_id', 'rating', 'user_id', 'datetimestamp'], 'required'],
            [['post_id', 'rating', 'user_id'], 'integer'],
            [['datetimestamp'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'post_id' => 'Post ID',
            'rating' => 'Rating',
            'user_id' => 'User ID',
            'datetimestamp' => 'Datetimestamp',
        ];
    }

    public function postRating($id){
        $likes = PostRatings::find()->where(['post_id'=>$id, 'rating'=>'1'])->count();
        $dislikes = PostRatings::find()->where(['post_id'=>$id, 'rating'=>'0'])->count();
        $stats = ['likes'=>$likes, 'dislikes'=>$dislikes];
        return $stats;
    }
}
