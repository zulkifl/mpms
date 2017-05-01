<?php

namespace common\models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * User model
 *
 * @property integer $id
 * @property string $username
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $email
 * @property string $auth_key
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $password write-only password
 * @property string $f_name
 * @property string $l_name
 * @property string $is_admin
 * @property string $is_active
 * @property string $pic
 * @property string $phone
 */
class User extends ActiveRecord implements IdentityInterface {

    const STATUS_DELETED = 0;
    const STATUS_ACTIVE = 10;

    public $fullname = "";
    public $name = "";
    public $rate = "";

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'es_user';
    }

    /**
     * @inheritdoc
     */
    public function behaviors() {
        return [
            TimestampBehavior::className(),
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_DELETED]],
            [['pic'], 'string', 'max' => 200],
            [['phone'], 'string', 'max' => 15],
            [['pic'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg,jpeg,gif'],
            [['f_name','l_name'], 'match', 'pattern' => '/^[a-zA-Z ]+$/', 'message' => Yii::t('app', 'Name should be alphabatic characters only.')],
            ['username', 'match', 'pattern' => '/^[a-zA-Z0-9]+$/', 'message' => Yii::t('app', 'Username should be alphabatic numeric  characters only.')],
        ];
    }

    public function attributeLabels() {
        return [
            'username' => Yii::t('app', 'User Name'),
            'f_name' => Yii::t('app', 'First Name'),
            'l_name' => Yii::t('app', 'Last Name'),
            'address' => Yii::t('app', 'Address'),
            'city' => Yii::t('app', 'City'),
            'country' => Yii::t('app', 'Country'),
            'is_admin' => Yii::t('app', 'Admin'),
            'is_active' => Yii::t('app', 'Active'),
            'email' => Yii::t('app', 'Email'),
            'account_type' => Yii::t('app', 'User Type'),
            'package' => Yii::t('app', 'Package'),
            'lat' => Yii::t('app', 'Latitude'),
            'lng' => Yii::t('app', 'Longitude'),
            'lang' => Yii::t('app', 'Language'),
            'pic' => Yii::t('app', 'Image'),
            'b_img' => Yii::t('app', 'Background Image'),
            'phone' => Yii::t('app', 'Phone'),
            'mobile' => Yii::t('app', 'Mobile'),
            'device' => Yii::t('app', 'Device'),
            'notes' => Yii::t('app', 'Overview'),
            'business_name' => Yii::t('app', 'Business Name'),
            'name' => Yii::t('app', 'Contact Person'),
            'c_timestamp' => Yii::t('app', 'Registration Date'),
            'rate' => Yii::t('app', 'Rating'),
            'orders' => Yii::t('app', 'No. of Orders'),
            'cityname' => Yii::t('app', 'City'),
            'countryname' => Yii::t('app', 'Country'),
            'rating2' => Yii::t('app', 'Rating'),
            'device_token' => Yii::t('app', 'Device Token'),
            'r_currency' => Yii::t('app', 'Currency'),
            'avg_rate' => Yii::t('app', 'Average Rate'),
            'showrate' => Yii::t('app', 'Average Rate'),
        ];
    }

    /**
     * @inheritdoc
     */
    public static function findIdentity($id) {
        return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null) {
        return static::findOne(['auth_key' => $token]);
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username) {
        return static::findOne(['username' => $username, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token) {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
                    'password_reset_token' => $token,
                    'status' => self::STATUS_ACTIVE,
        ]);
    }

    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return boolean
     */
    public static function isPasswordResetTokenValid($token) {
        if (empty($token)) {
            return false;
        }
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        $parts = explode('_', $token);
        $timestamp = (int) end($parts);
        return $timestamp + $expire >= time();
    }

    /**
     * @inheritdoc
     */
    public function getIsAdmin() {
        return $this->is_admin;
    }

    public function getIsActive() {
        return $this->is_active;
    }

    public function getId() {
        return $this->getPrimaryKey();
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey() {
        return $this->auth_key;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey) {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password) {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password) {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey() {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken() {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken() {
        $this->password_reset_token = null;
    }

    public function afterFind() {
        $this->fullname = $this->f_name != "" ? $this->f_name . ' ' . $this->l_name : $this->username;
        $this->name = $this->f_name . ' ' . $this->l_name;


        parent::afterFind();
    }

}
