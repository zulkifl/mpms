<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Serviceprovider */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="serviceprovider-form">

    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <div class="col-md-3">
            <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'phone')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'mobile')->textInput(['maxlength' => true]) ?>

        </div>
    </div>

    <div class="row">
        <div class="col-md-3">

            <?= $form->field($model, 'address')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-3">

            <?= $form->field($model, 'address2')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-3">

            <?= $form->field($model, 'city_id')->dropDownList(common\config\Options::getCities(), ['prompt' => Yii::t('app', 'Select City')]) ?>
        </div>

        <div class="col-md-3">

            <?= $form->field($model, 'category_id')->dropDownList(common\config\Options::getCategories(), ['prompt' => Yii::t('app', 'Select Category')]) ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'website')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'keywords')->textInput(['maxlength' => true]) ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <?= $form->field($model, 'services')->textarea(['rows' => 3]) ?>
        </div>
    </div>
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
