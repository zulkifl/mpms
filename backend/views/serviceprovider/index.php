<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\ServiceproviderSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Service Providers');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="serviceprovider-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create Service Provider'), ['create'], ['class' => 'btn btn-success']) ?>
        <?php if (Yii::$app->user->identity->is_admin == '1') { ?>
            <?= Html::a(Yii::t('app', 'Export Service Provider'), ['export'], ['class' => 'btn btn-success']) ?>
            <?= Html::a(Yii::t('app', 'Import Service Provider'), ['import'], ['class' => 'btn btn-success']) ?>
        <?php } ?>
    </p>

    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'name',
            [
                'attribute' => 'category_id',
                'value' => 'category',
                'filter' => Html::activeDropDownList($searchModel, 'category_id', common\config\Options::getCategories(), ['class' => 'form-control', 'prompt' => Yii::t('app', 'Select Category')]),
            ],
            'email:email',
            // 'website',
            // 'keywords',
            // 'phone',
            'mobile',
            'address',
            'address2',
            [
                'attribute' => 'city_id',
                'value' => 'city',
                'filter' => Html::activeDropDownList($searchModel, 'city_id', common\config\Options::getCities(), ['class' => 'form-control', 'prompt' => Yii::t('app', 'Select City')]),
            ],
            [
                'attribute' => 'country_id',
                'value' => 'country',
                'filter' => Html::activeDropDownList($searchModel, 'country_id', common\config\Options::getCountries(), ['class' => 'form-control', 'prompt' => Yii::t('app', 'Select State')]),
            ],
            // 'services:ntext',
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]);
    ?>

</div>
