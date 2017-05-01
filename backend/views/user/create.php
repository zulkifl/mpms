<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Unames */

$this->title = Yii::t('app', 'Create User');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Users'), 'url' => ['index']];

$this->params['breadcrumbs'][] = Yii::t('app', 'Create');
?>
<p>
    <?= Html::a('List', ['index'], ['class' => 'btn btn-primary']) ?>
</p>
<div class="unames-create">

    

    <?= $this->render('signup', [
        'model' => $model,
    ]) ?>

</div>
