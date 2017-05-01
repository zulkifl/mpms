<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\CitiesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Cities');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cities-index">

    
    <?php // echo $this->render('_search', ['model' => $searchModel]); 
    $colname = Yii::$app->language == 'ar' ? 'name_ar' : 'name';
    ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create ').\common\config\Options::getOptionName(\common\config\Controller2::CITY), ['create'], ['class' => 'btn btn-success']) ?>
<?php if (Yii::$app->user->identity->is_admin == '1') {?>
        <?= Html::a(Yii::t('app', 'Export') . ' ' . common\config\Options::getOptionName(common\config\Controller2::CITY), ['export'], ['class' => 'btn btn-success']) ?>
<?php }?>
    </p>

    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'name',
            [
                'attribute' => 'country_id',
                'value' => 'country',
                'filter' => Html::activeDropDownList($searchModel, 'country_id', ArrayHelper::map(\common\models\Countries::find()->where(["active" => '1'])->asArray()->all(), 'id', $colname), ['class' => 'form-control', 'prompt' => Yii::t('app', 'Select State')]),
            ],
            [
                'attribute' => 'active',
                'value' => function($model, $index, $dataColumn) {
            $decs = $model->active == "1" ? Yii::t('app', "Yes") : Yii::t('app', "No");
            return $decs;
        },
                'filter' => Html::activeDropDownList($searchModel, 'active', ArrayHelper::map([['id' => 1, 'name' => Yii::t('app', "Yes")], ['id' => 0, 'name' => Yii::t('app', "No")]], 'id', 'name'), ['class' => 'form-control', 'prompt' => Yii::t('app', 'Select Active')]),
            ],
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]);
    ?>

</div>
