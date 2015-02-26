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
            [['title', 'description', 'category_id', 'owner_id', 'price', 'currency', 'max_active_orders', 'max_delivery_days'], 'required'],
            [['description'], 'string'],
            [['category_id', 'owner_id', 'featured', 'max_active_orders', 'max_delivery_days', 'active'], 'integer'],
            [['expiry_date', 'datetimestamp'], 'safe'],
            [['title'], 'string', 'max' => 100, 'min'=>'20'],
            [['price', 'currency'], 'string', 'max' => 10],
            [['image_url'], 'file', 'extensions' => 'jpg, png, jpeg, bmp', 'maxSize'=>1],
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
            'image_url' => 'Promotional Image',
            'expiry_date' => 'Expiry Date',
            'featured' => 'Featured',
            'datetimestamp' => 'Datetimestamp',
            'max_active_orders' => 'Maximum Active Orders',
            'max_delivery_days' => 'Maximum Delivery Days',
            'active' => 'Active',
        ];
    }
}
