<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "post_category".
 *
 * @property integer $category_id
 * @property string $category_name
 * @property string $created_date
 * @property integer $created_by
 */
class PostCategory extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'post_category';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['category_name', 'created_by'], 'required'],
            [['category_name'], 'string'],
            [['category_name'], 'match', 'pattern' => '/^[a-zA-Z\s]+$/', 'message' => 'Category name can only contain alphabet characters'],
            [['created_date', 'category_pic'], 'safe'],
            [['created_by'], 'integer'],
            [['category_pic'], 'file', 'extensions'=>'png, jpg, jpeg, bmp'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'category_id' => 'Category',
            'category_name' => 'Category Name',
            'created_date' => 'Created Date',
            'created_by' => 'Created By',
            'category_pic' => 'Category Picture',
        ];
    }


      public function getPosts(){
        return $this->hasMany(PostServices::className(), ['category_id'=>'category_id']);
    }
}
