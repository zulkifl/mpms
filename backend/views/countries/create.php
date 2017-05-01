<?php

use yii\helpers\Html;
use common\config\Options;
use common\config\Controller2;

/* @var $this yii\web\View */
/* @var $model common\models\Countries */

$this->title =  Yii::t('app', 'Create') . ' ' . Options::getOptionName(Controller2::COUNTRY);
$this->params['breadcrumbs'][] = ['label' => Options::getOptionPName(Controller2::COUNTRY), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="countries-create">

    

    <?= $this->render('_form', [
        'model' => $model
    ]) ?>

</div>
