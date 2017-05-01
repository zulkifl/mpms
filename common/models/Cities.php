<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "es_cities".
 *
 * @property integer $id
 * @property string $name
 * @property integer $country_id
 * @property string $c_timestamp
 * @property string $active
 */
class Cities extends \common\config\ActiveRecord2 {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'es_cities';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['name', 'country_id'], 'required'],
            [['country_id'], 'integer'],
            [['c_timestamp'], 'safe'],
            [['name'], 'string', 'max' => 255],
            [['active'], 'string', 'max' => 1]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
            'country_id' => Yii::t('app', 'State'),
             'country' => Yii::t('app', 'State'),
            'c_timestamp' => Yii::t('app', 'C Timestamp'),
            'active' => Yii::t('app', 'Active'),
        ];
    }

    public function getCountry() {
        $city = Countries::findOne($this->country_id);
        if ($city != null)
            return Yii::t('app', $city->name);
        else
            return "";
    }

}
