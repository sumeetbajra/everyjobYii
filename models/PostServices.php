<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "post_services".
 *
 * @property integer $post_id
 * @property string $description
 * @property integer $category_id
 * @property integer $owner_id
 * @property string $price
 * @property string $image_url
 * @property string $expiry_date
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
            [['description', 'category_id', 'owner_id', 'price', 'max_active_orders', 'max_delivery_days'], 'required'],
            [['description'], 'string'],
            [['category_id', 'owner_id', 'max_active_orders', 'max_delivery_days', 'active'], 'integer'],
            [['expiry_date', 'datetimestamp'], 'safe'],
            [['price'], 'string', 'max' => 10],
            [['image_url'], 'file']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'post_id' => 'Post ID',
            'description' => 'Description',
            'category_id' => 'Category ID',
            'owner_id' => 'Owner ID',
            'price' => 'Price',
            'image_url' => 'Promotional Image',
            'expiry_date' => 'Expiry Date',
            'datetimestamp' => 'Datetimestamp',
            'max_active_orders' => 'Maximum Active Orders',
            'max_delivery_days' => 'Maximum Delivery Days',
            'active' => 'Active',
        ];
    }
}
