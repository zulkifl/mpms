<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "es_category".
 *
 * @property integer $id
 * @property string $name
 * @property string $c_timestamp
 * @property string $c_img
 * @property string $active
 * @property string $mapshow
 * @property string $b_img
 * @property string $description
 * @property integer $order
 * @property integer $views
 */
class Category extends \common\config\ActiveRecord2 {

    /**
     * @inheritdoc
     */
    //public $c_img;

    
    public static function tableName() {
        return 'es_category';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['name'], 'required'],
            [['c_timestamp'], 'safe'],
            [['order','views'], 'integer'],
            [['active', 'mapshow'], 'string', 'max' => 1],
            [['name', 'b_img', 'c_img'], 'string', 'max' => 255],
            [['description'], 'string', 'max' => 2000],
            [['detail'], 'string']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
            'c_timestamp' => Yii::t('app', 'Time Stamp'),
            'active' => Yii::t('app', 'Active'),
            'mapshow' => Yii::t('app', 'Show on Map'),
            'c_img' => Yii::t('app', 'Icon'),
            'b_img' => Yii::t('app', 'Background Image'),
            'description' => Yii::t('app', 'Description'),
            'detail' => Yii::t('app', 'More Detail'),
            'order' => Yii::t('app', 'Show Order'),
            'subcategories' =>Yii::t('app', 'Sub Categories'),
            'subcategoriesarr'=>Yii::t('app', 'Sub Categories'),
        ];
    }

    public function getSubcategoriesarr() {
        $s =  Subcategory::find()->where(['category_id'=> $this->id])->all();
        $rtn =array();
        foreach ($s as $value) {
            $rtn[] = $value->name;
        }
        return $rtn;
    }
    public function getSubcategories() {
        $searchModel = new SubcategorySearch();
        $searchModel->category_id = $this->id;
        return $searchModel->search(Yii::$app->request->queryParams);
    }

    public function getProviders() {
        $searchModel = new ProvidercategorySearch();
        $searchModel->category_id = $this->id;
        return $searchModel->search(Yii::$app->request->queryParams);
    }

    public function getBusinesses() {
        $searchModel = new BusinessSearch();
        $searchModel->category_id = $this->id;
        return $searchModel->search(Yii::$app->request->queryParams);
    }

    public function getProvider() {
        return $this->hasMany(Providercategory::className(), ['category_id' => 'id']);
    }

}
