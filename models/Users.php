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
            [['fname', 'lname', 'gender', 'dob', 'display_name', 'password', 'created_at', 'email', 'updated_at'], 'required'],
            [['dob', 'created_at', 'updated_at'], 'safe'],
            [['active', 'verified'], 'integer'],
            [['fname', 'lname', 'display_name', 'email', 'accessToken'], 'string', 'max' => 200],
            [['gender'], 'string', 'max' => 6],
            [['password'], 'string', 'max' => 255],
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
            'fname' => 'Fname',
            'lname' => 'Lname',
            'gender' => 'Gender',
            'dob' => 'Dob',
            'display_name' => 'Display Name',
            'password' => 'Password',
            'created_at' => 'Created At',
            'active' => 'Active',
            'authKey' => 'Auth Key',
            'email' => 'Email',
            'verified' => 'Verified',
            'updated_at' => 'Updated At',
            'accessToken' => 'Access Token',
        ];
    }
}
