<?php

use yii\helpers\Html;
use common\config\Options;
use common\config\Controller2;
/* @var $this yii\web\View */
/* @var $model common\models\Cities */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => Options::getOptionName(Controller2::CITY),
]) . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => Options::getOptionPName(Controller2::CITY), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="cities-update">

    

    <?= $this->render('_form', [
        'model' => $model
    ]) ?>

</div>
