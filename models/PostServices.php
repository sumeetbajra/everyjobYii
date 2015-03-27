<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "post_services".
 *
 * @property integer $post_id
 * @property string $title
 * @property string $description
 * @property integer $category_id
 * @property integer $owner_id
 * @property string $price
 * @property string $currency
 * @property string $image_url
 * @property string $expiry_date
 * @property integer $featured
 * @property string $datetimestamp
 * @property integer $max_active_orders
 * @property integer $max_delivery_days
 * @property integer $active
 * @property string $slug
 * @property string $tags
 */
class PostServices extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'post_services';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'description', 'category_id', 'owner_id', 'price', 'currency', 'datetimestamp', 'max_active_orders', 'max_delivery_days', 'slug'], 'required'],
            [['description'], 'string'],
            [['category_id', 'owner_id', 'featured', 'max_active_orders', 'max_delivery_days', 'active'], 'integer'],
            [['expiry_date', 'datetimestamp'], 'safe'],
            [['title'], 'string', 'max' => 100],
            [['price', 'currency'], 'string', 'max' => 10],
            [['image_url', 'slug', 'tags'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'post_id' => 'Post ID',
            'title' => 'Title',
            'description' => 'Description',
            'category_id' => 'Category ID',
            'owner_id' => 'Owner ID',
            'price' => 'Price',
            'currency' => 'Currency',
            'image_url' => 'Image Url',
            'expiry_date' => 'Expiry Date',
            'featured' => 'Featured',
            'datetimestamp' => 'Datetimestamp',
            'max_active_orders' => 'Max Active Orders',
            'max_delivery_days' => 'Max Delivery Days',
            'active' => 'Active',
            'slug' => 'Slug',
            'tags' => 'Tags',
        ];
    }

        public function getOwner()
    {
        // Customer has_many Order via Order.customer_id -> id
        return $this->hasOne(Users::className(), ['user_id' => 'owner_id']);
    }

    public function getCategory()
    {
        // Customer has_many Order via Order.customer_id -> id
        return $this->hasOne(PostCategory::className(), ['category_id' => 'category_id']);
    }

    public function getRatings(){
        return $this->hasMany(PostRatings::className(), ['post_id'=>'post_id']);
    }

       public function getViews(){
        return $this->hasMany(PostViews::className(), ['post_id'=>'post_id']);
    }
}
