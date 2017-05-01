<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Serviceprovider */

$this->title = Yii::t('app', 'Create Service Provider');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Service Providers'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="serviceprovider-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
