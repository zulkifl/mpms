<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\bootstrap\Modal;

/* @var $this yii\web\View */
/* @var $model backend\models\Unames */

$this->title = $model->username;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Users'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="unames-view">
    <p>
         <?= Html::a(Yii::t('app', 'List'), ['index'], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
    </p>


    <div class="row">
        <div class="col-md-12">
            <?=
            DetailView::widget([
                'model' => $model,
                'attributes' => [
                    'username',
                    'f_name',
                    'l_name',
                    'email',
                   
                    'phone',
                    'c_timestamp'
                ],
            ])
            ?>
        </div>
    </div>
</div>