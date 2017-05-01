<?php

use yii\helpers\Html;
use common\config\Options;
use common\config\Controller2;

/* @var $this yii\web\View */
/* @var $model common\models\Category */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' =>  Options::getOptionName(Controller2::CATEGORY)
]) . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Categories'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="category-update">
    <?= $this->render('_form', [
        'model' => $model
    ]) ?>

</div>
