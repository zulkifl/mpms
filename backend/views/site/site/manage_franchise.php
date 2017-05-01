<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $searchModel common\models\FranchiseSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Franchises');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="franchise-index">

    
    <?php // echo $this->render('_search', ['model' => $searchModel]);  ?>

    <?php if (Yii::$app->session->getFlash('s_mesage')) { ?>
        <div class="alert alert-success">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            <?= Yii::$app->session->getFlash('s_mesage'); ?>
        </div>
        <?php
    }
    $colname = Yii::$app->language == 'ar' ? 'name_ar' : 'name';
    ?>
    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'add_title',
                'value' => function($model, $index, $dataColumn) {
            return Html::a($model->add_title, Yii::$app->urlManager->createUrl(["/site/franchiseview", 'id' => $model->id]));
        },
                'format' => 'raw'
            ],
            [
                'attribute' => 'status',
                'content' => function($data) {
            if ($data->status == 2) {
                $data = "Approved\n" . Html::a(Yii::t('app', 'Un-Approve It'), ['site/franchisestatus', 'id' => $data->id]
                );
            } else {

                $data = "Un-Approved\n" . Html::a(Yii::t('app', 'Approve It'), ['site/franchisestatus_active', 'id' => $data->id]
                );
            }
            return $data;
        },
                'filter' => Html::activeDropDownList($searchModel, 'status', ArrayHelper::map([['id' => 1, 'name' => Yii::t('app', "Un-Approved")], ['id' => 2, 'name' => Yii::t('app', "Approved")]], 'id', 'name'), ['class' => 'form-control', 'prompt' => Yii::t('app', 'Select Status')]),
            ],
//            [
//                'attribute' => 'c_timestamp',
//                'value' => 'c_timestamp',
//                'format' => 'raw',
//                'filter' => DatePicker::widget([
//                    'model' => $searchModel,
//                    'attribute' => 'c_timestamp',
//                    'clientOptions' => [
//                        'autoclose' => true,
//                        'format' => 'yyyy-M-dd'
//            ]])
//            ],
            'c_timestamp',
            'description:ntext',
            'price',
            [
                'attribute' => 'city',
                'value' => function($model, $index, $dataColumn) {
            $decs = "";
            if ($model->city == "") {
                $city = \common\models\Cities::findOne($model->city);
                if ($city !== null) {
                    $decs = Yii::$app->language == 'ar' ? $city->name_ar : $city->name;
                }
            }

            return $decs;
        },
                'filter' => Html::activeDropDownList($searchModel, 'city', ArrayHelper::map(\common\models\Cities::find()->where(['active' => '1'])->asArray()->all(), 'id', $colname), ['class' => 'form-control', 'prompt' => Yii::t('app', 'Select City')]),
            ]
        ]
    ]);
    ?>

</div>
