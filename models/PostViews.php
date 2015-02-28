<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "post_views".
 *
 * @property integer $post_id
 * @property integer $view_count
 */
class PostViews extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'post_views';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['post_id', 'view_count'], 'required'],
            [['post_id', 'view_count'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'post_id' => 'Post ID',
            'view_count' => 'View Count',
        ];
    }
}
