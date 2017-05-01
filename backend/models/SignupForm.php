<?php

namespace backend\models;

use common\models\User;
use yii\base\Model;
use Yii;

/**
 * Signup form
 */
class SignupForm extends Model {

    public $username;
    public $email;
    public $password;
    public $f_name;
    public $l_name;
    public $pic;
    public $phone;
    public $mobile;

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            ['username', 'filter', 'filter' => 'trim'],
            ['username', 'required'],
            ['f_name', 'required'],
            ['username', 'unique', 'targetClass' => '\common\models\User', 'message' => Yii::t('app','This username has already been taken.')],
            ['username', 'string', 'min' => 2, 'max' => 255],
            ['pic', 'file'],
            //['pic', 'required'],
            [['phone', 'mobile'], 'string',  'max' => 15],
            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'unique', 'targetClass' => '\common\models\User', 'message' => Yii::t('app','This email address has already been taken.')],
            ['password', 'required'],
            ['password', 'string', 'min' => 6],
            [['f_name','l_name'], 'match', 'pattern' => '/^[a-zA-Z ]+$/', 'message' => Yii::t('app', 'Name should be alphabatic characters only.')],
            ['username', 'match', 'pattern' => '/^[a-zA-Z0-9]+$/', 'message' => Yii::t('app', 'Username should be alphabatic numeric characters only.')],
        ];
    }

    public function attributeLabels() {

        return [
            'username' => Yii::t('app', 'Username'),
            'password'=> Yii::t('app', 'Password'),
            'email'=> Yii::t('app', 'Email'),
            'f_name' => Yii::t('app', 'First Name'),
            'l_name' => Yii::t('app', 'Last Name'),
            'address' => Yii::t('app', 'Address'),
            'city' => Yii::t('app', 'City'),
            'country' => Yii::t('app', 'Country'),
            'pic' => Yii::t('app', 'Logo/Pic'),
            'sp'=> Yii::t('app', 'Service Provider'),
            'phone'=> Yii::t('app', 'Phone'),
            'mobile'=> Yii::t('app', 'Mobile'),
            
        ];
    }

    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function signup($pic) {
        if ($this->validate()) {
            $user = new User();
            $sData = Yii::$app->request->post('SignupForm');
            $user->username = $this->username;
            $user->email = $this->email;
            $user->setPassword($this->password);
            $user->f_name = $sData['f_name'];
            $user->l_name = $sData['l_name'];
            $user->pic = $pic;
            $user->phone = $sData['phone'];
            
            $user->generateAuthKey();
            if ($user->save()) {
                return $user;
            }
        }

        return null;
    }

}
