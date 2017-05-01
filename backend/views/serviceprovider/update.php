<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Serviceprovider */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Service Provider',
]) . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Service Providers'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="serviceprovider-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
