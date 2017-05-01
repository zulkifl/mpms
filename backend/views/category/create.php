<?php

use yii\helpers\Html;
use common\config\Options;
use common\config\Controller2;

/* @var $this yii\web\View */
/* @var $model common\models\Category */

$this->title = Yii::t('app', 'Create') . ' ' . Options::getOptionName(Controller2::CATEGORY);
$this->params['breadcrumbs'][] = ['label' => Options::getOptionPName(Controller2::CATEGORY), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="category-create">
    <?=
    $this->render('_form', [
        'model' => $model  ])
    ?>

</div>
