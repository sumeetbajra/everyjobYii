<?php

namespace app\models;
use app\models\Users as Users;

class User extends \yii\base\Object implements \yii\web\IdentityInterface
{
    public $user_id;
    public $email;
    public $fname;
    public $password;
    public $authKey, $username, $address, $about, $profilePic;
    public $accessToken, $lname, $gender, $dob, $display_name, $created_at, $active, $verified, $updated_at;

    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        $dbUser = Users::find()
        ->where([
            "user_id" => $id
            ])
        ->one();
        if (!count($dbUser)) {
            return null;
        }
        return new static($dbUser);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        $dbUser = Users::find()
       ->where(["accessToken" => $token])
       ->one();
       if (!count($dbUser)) {
        return null;
    }
    return new static($dbUser);
}

    /**
     * Finds user by username
     *
     * @param  string      $username
     * @return static|null
     */
   public static function findByUsername($username) {
    $dbUser = Users::find()
            ->where([
                "email" => $username
            ])
            ->one();
    if (!count($dbUser)) {
        return null;
    }
    return new static($dbUser);
}

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->user_id;
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->authKey;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->authKey === $authKey;
    }

    /**
     * Validates password
     *
     * @param  string  $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return $this->password === $password;
    }
}
