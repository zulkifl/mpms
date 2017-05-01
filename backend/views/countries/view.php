<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\bootstrap\Modal;
use common\config\Options;
use common\config\Controller2;

/* @var $this yii\web\View */
/* @var $model common\models\Countries */

$this->title = Options::getOptionName(Controller2::COUNTRY) . ": " . $model->name;
$this->params['breadcrumbs'][] = ['label' => Options::getOptionPName(Controller2::COUNTRY), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="countries-view">



    <p>
        <?= Html::a(Yii::t('app', 'List'), ['index'], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?=
        Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ])
        ?>
    </p>


    <?=
    DetailView::widget([
        'model' => $model,
        'attributes' => [
            [
                'attribute' => 'name',
                'value' => $model->name,
                'format' => 'html',
            ],
            [
                'attribute' => 'active',
                'value' => Options::getYesNoById($model->active)
            ],
        ],
    ])
    ?>

</div>

