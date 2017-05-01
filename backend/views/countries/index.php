<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use common\config\Options;
use common\config\Controller2;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\CountriesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Options::getOptionPName(Controller2::COUNTRY);
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="countries-index">


<?php // echo $this->render('_search', ['model' => $searchModel]);  ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create') . ' ' . Options::getOptionName(Controller2::COUNTRY), ['create'], ['class' => 'btn btn-success']) ?>
<?php if (Yii::$app->user->identity->is_admin == '1') {?>
        <?= Html::a(Yii::t('app', 'Export') . ' ' . common\config\Options::getOptionName(common\config\Controller2::COUNTRY), ['export'], ['class' => 'btn btn-success']) ?>
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
                'attribute' => 'active',
                'value' => function($model, $index, $dataColumn) {
                    $decs = Options::getYesNoById($model->active);
                    return $decs;
                },
                'filter' => Html::activeDropDownList($searchModel, 'active', ArrayHelper::map([['id' => 1, 'name' => "Yes"], ['id' => 0, 'name' => "No"]], 'id', 'name'), ['class' => 'form-control', 'prompt' => 'Select Active']),
            ],
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]);
    ?>

</div>
