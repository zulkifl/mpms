<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use common\models\Countries;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\SignupForm */
//
//$this->title = 'Signup';
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-signup">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
    <div class="row">
        <div class="col-sm-6">
            <?= $form->field($model, 'username') ?>
        </div>
        <div class="col-sm-6">
            <?= $form->field($model, 'email') ?>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6">
            <?= $form->field($model, 'f_name') ?>
        </div>
        <div class="col-sm-6">
            <?= $form->field($model, 'l_name') ?>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6">
            <?= $form->field($model, 'password')->passwordInput() ?>
        </div>
        <div class="col-sm-6">
            <label><?= Yii::t('app', 'Confirm Password') ?></label>
            <input type="password" name="c_type" id="c_type" class="form-control" value="" />
            <p id="c_pas" style="color: #a94442;"></p>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6">
            <?= $form->field($model, 'phone') ?>
        </div>
       
    </div>

   <div class="form-group">
        <?= Html::submitButton( Yii::t('app', 'Create') , ['class' => 'btn btn-success' ]) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
