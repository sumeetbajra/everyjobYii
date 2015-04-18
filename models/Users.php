<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "users".
 *
 * @property integer $user_id
 * @property string $fname
 * @property string $lname
 * @property string $gender
 * @property string $dob
 * @property string $display_name
 * @property string $address
 * @property string $about
 * @property string $profilePic
 * @property string $password
 * @property string $created_at
 * @property integer $active
 * @property string $authKey
 * @property string $email
 * @property integer $verified
 * @property string $updated_at
 * @property string $accessToken
 */
class Users extends \yii\db\ActiveRecord
{
    public $rememberMe;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'users';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['fname', 'lname', 'gender', 'dob', 'display_name', 'address', 'about', 'password', 'created_at', 'email', 'about', 'address'], 'required'],
            [['dob', 'created_at', 'updated_at', 'facebook_url', 'linkedin_url', 'google_url', 'twitter_url'], 'safe'],
            [['about'], 'string'],
            [['active', 'verified'], 'integer'],
            ['fname', 'match', 'pattern' => '/^[a-zA-Z\s]+$/', 'message' => 'First Name can only contain alphabet characters'],
            ['fname', 'match', 'pattern' => '/^[a-zA-Z\s]+$/', 'message' => 'First Name can only contain alphabet characters'],
            ['lname', 'match', 'pattern' => '/^[a-zA-Z\s]+$/', 'message' => 'Last Name can only contain alphabet characters'],
            ['email', 'email'],
            ['email', 'unique'],
            ['display_name', 'unique'],
            [['profilePic'], 'file', 'extensions'=>'png, jpg, jpeg, bmp'],
            [['fname', 'lname', 'display_name', 'email', 'accessToken'], 'string', 'max' => 200],
            [['gender'], 'string', 'max' => 6],
            [['password'], 'string', 'min'=>8],
            [['about'], 'string', 'min'=>20, 'max'=>400],
            [['address', 'password'], 'string', 'max' => 255],
            [['authKey'], 'string', 'max' => 100]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'user_id' => 'User ID',
            'fname' => 'First name',
            'lname' => 'Last name',
            'gender' => 'Gender',
            'dob' => 'Dob',
            'display_name' => 'Display Name',
            'address' => 'Address',
            'about' => 'About',
            'profilePic' => 'Profile Pic',
            'password' => 'Password',
            'created_at' => 'Created At',
            'active' => 'Active',
            'authKey' => 'Auth Key',
            'email' => 'Email',
            'verified' => 'Verified',
            'updated_at' => 'Updated At',
            'accessToken' => 'Access Token',
            'facebook_url' => 'Facebook Profile Link',
            'google_url' => 'Google Plus Profile Link',
            'linkedin_url' => 'LinkedIn Profile Link',
            'twitter_url' => 'Twitter Profile Link',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPosts()
    {
        return $this->hasMany(PostServices::className(), ['owner_id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBought()
    {
        return $this->hasMany(AcceptedOrders::className(), ['user_id' => 'user_id']);
    }
}
