<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use common\config\Options;
use common\config\Controller2;
use kartik\export\ExportMenu;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\CountriesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Options::getOptionPName(Controller2::CATEGORY);
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="countries-index">


    <?php // echo $this->render('_search', ['model' => $searchModel]);  ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create') . ' ' . Options::getOptionName(Controller2::CATEGORY), ['create'], ['class' => 'btn btn-success']) ?>
        <?php if (Yii::$app->user->identity->is_admin == '1') { ?>

            <?= Html::a(Yii::t('app', 'Export') . ' ' . Options::getOptionName(Controller2::CATEGORY), ['export'], ['class' => 'btn btn-success']) ?>
        <?php } ?>
    </p>
    <?php
    $columns = [
        ['class' => 'yii\grid\SerialColumn'],
        'name',
        [
            'attribute' => 'active',
            'value' => function($model, $index, $dataColumn) {
                return Options::getYesNoById($model->active);
            },
            'filter' => Html::activeDropDownList($searchModel, 'active', Options ::getYesNo(), ['class' => 'form-control', 'prompt' => Yii::t('app', 'Select Active')]),
        ],
        ['class' => 'yii\grid\ActionColumn'],
    ];
    ?>

    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => $columns
    ]);
    ?>

</div>
