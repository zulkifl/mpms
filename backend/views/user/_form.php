<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use common\models\Countries;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model backend\models\Unames */
/* @var $form yii\widgets\ActiveForm */
$colname = 'name';
?>

<div class="unames-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
    <div class="row">
        <div class="col-md-3">
            <?= $form->field($model, 'username')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'l_name')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'f_name')->textInput(['maxlength' => true]) ?>
        </div>
        
    </div>
    <div class="row">
        <div class="col-md-3">
            <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'phone')->textInput(['maxlength' => true]) ?>
        </div>

        <div class="col-md-2">
            <br>
            <?= $form->field($model, 'is_active')->checkbox() ?>
        </div>
        <div class="col-md-3">
            <br>
            <?= $form->field($model, 'is_admin')->checkbox() ?>
        </div>
    </div>

     <div class="row">

        <div class="col-md-6">
            <?= $form->field($model, 'pic')->fileInput() ?>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
