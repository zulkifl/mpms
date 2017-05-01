<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "es_serviceprovider".
 *
 * @property integer $id
 * @property string $name
 * @property string $address
 * @property string $address2
 * @property integer $city_id
 * @property integer $country_id
 * @property integer $category_id
 * @property string $email
 * @property string $website
 * @property string $keywords
 * @property string $phone
 * @property string $mobile
 * @property string $services
 */
class Serviceprovider extends \common\config\ActiveRecord2 {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'es_serviceprovider';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['name', 'mobile'], 'required'],
            //['name', 'match', 'pattern' => '/^[a-zA-Z ]+$/','message'=>Yii::t('app','Name should be alphabatic characters only.')],
            [['email'], 'email'],
            [['website'], 'url'],
            [['city_id', 'country_id', 'category_id'], 'integer'],
            [['services'], 'string'],
            [['name', 'email'], 'string', 'max' => 150],
            [['address','address2', 'website'], 'string', 'max' => 255],
            [['keywords'], 'string', 'max' => 1000],
            [['phone', 'mobile'], 'string', 'max' => 20]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
            'address' => Yii::t('app', 'Address'),
            'address2' => Yii::t('app', 'Address 2'),
            'city_id' => Yii::t('app', 'City'),
            'country_id' => Yii::t('app', 'State'),
            'category_id' => Yii::t('app', 'Category'),
            'city' => Yii::t('app', 'City'),
            'country' => Yii::t('app', 'State'),
            'category' => Yii::t('app', 'Category'),
            'email' => Yii::t('app', 'Email'),
            'website' => Yii::t('app', 'Website'),
            'keywords' => Yii::t('app', 'Keywords'),
            'phone' => Yii::t('app', 'Phone'),
            'mobile' => Yii::t('app', 'Mobile'),
            'services' => Yii::t('app', 'Services'),
        ];
    }

    public function beforeSave($insert) {
        if ($this->city_id != null) {
            $c = Cities::findOne($this->city_id);
            if ($c != null) {
                $this->country_id = $c->country_id;
            }
        }
        return parent::beforeSave($insert);
    }

    public function getCity() {
        $city = Cities::findOne($this->city_id);
        if ($city != null)
            return Yii::t('app', $city->name);
        else
            return "";
    }

    public function getCountry() {
        $city = Countries::findOne($this->country_id);
        if ($city != null)
            return Yii::t('app', $city->name);
        else
            return "";
    }

    public function getCategory() {
        $city = Category::findOne($this->category_id);
        if ($city != null)
            return Yii::t('app', $city->name);
        else
            return "";
    }

}
