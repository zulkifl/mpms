<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "es_countries".
 *
 * @property integer $id
 * @property string $name
 * @property string $c_timestamp
 * @property string  $active
 */
class Countries extends \common\config\ActiveRecord2 {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'es_countries';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['name'], 'required'],
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
        'active' => Yii::t('app', 'Active'),
        'c_timestamp' => Yii::t('app', 'C Timestamp'),
        'city' => Yii::t('app', 'Cities'),
        ];
    }

    public function getCities() {
        $searchModel = new \common\models\CitiesSearch;
        $searchModel->country_id = $this->id;
        return $searchModel->search(Yii::$app->request->queryParams);
    }

    public function getCity() {
        $s = Cities::find()->where(['country_id' => $this->id])->all();
        $rtn = array();
        foreach ($s as $value) {
            $rtn[] = $value->name;
        }
        return $rtn;
    }

}
