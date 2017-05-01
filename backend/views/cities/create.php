<?php

use yii\helpers\Html;
use common\config\Options;
use common\config\Controller2;

/* @var $this yii\web\View */
/* @var $model common\models\Cities */

$this->title = Yii::t('app', 'Create').' '.Options::getOptionName(Controller2::CITY);
$this->params['breadcrumbs'][] = ['label' => Options::getOptionPName(Controller2::CITY), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cities-create">

    

    <?= $this->render('_form', [
        'model' => $model
    ]) ?>

</div>
