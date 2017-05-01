<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Unames */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
            'modelClass' => \common\config\Options::getOptionName(\common\config\Controller2::USERS),
        ]) . ' ' . $model->username;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Users'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->username, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<p>
    <?= Html::a('List', ['index'], ['class' => 'btn btn-primary']) ?>
</p>

<div class="unames-update">

    <?= $this->render('_form', [ 'model' => $model,])?>

</div>
