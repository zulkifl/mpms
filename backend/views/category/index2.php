<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use common\config\Options;
use common\config\Controller2;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\CountriesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Options::getOptionPName(Controller2::CATEGORY_REQUEST);
$this->params['breadcrumbs'][] = $this->title;
?>
<p>
     <?= Html::a(Options::getOptionPName(Controller2::CATEGORY), ['index'], ['class' => 'btn btn-primary']) ?>
    
</p>
<div class="countries-index">


    <?php // echo $this->render('_search', ['model' => $searchModel]);  ?>

    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'name',
            [
                'attribute' => 'user_id',
                'value' => function($model, $index, $dataColumn) {
                    $decs = '';
                    $lm = \common\models\User::findOne($model->user_id);
                    if ($lm != null) {
                        $decs = $lm->username;
                    }
                    return $decs;
                },
            ],
            ['class' => 'yii\grid\ActionColumn',
                'template' => '{create}{delete}',
                'buttons' => [
                     'create' => function ($url, $model, $key) {
                                        /** @var ActionColumn $column */
                                        $url = Yii::$app->urlManager->createUrl(['/category/create', 'name' => $model->name]);
                                        return Html::a('<span class="glyphicon glyphicon-pencil"></span>', 
                                                $url, ['title' => Yii::t('yii', 'Create'),
                                        ]);
                                    },
                    'delete' => function ($url, $model, $key) {
                        /** @var ActionColumn $column */
                        $url = Yii::$app->urlManager->createUrl(['/category/deleterequest', 'id' => $model->id]);
                        return Html::a('<span class="glyphicon glyphicon-trash"></span>', $url, [
                                    'title' => Yii::t('yii', 'Delete'),
                                    'data-confirm' => Yii::t('yii', 'Are you sure to delete this item?'),
                                    'data-method' => 'post',
                        ]);
                    },
                        ]],
                ],
            ]);
            ?>

</div>
