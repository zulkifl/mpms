<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \\common\models\ResetPasswordForm */
//
//$this->title = 'Reset password';
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-reset-password">
    <h1 style=" margin-top:8%;"><?php //Html::encode($this->title) ?></h1>

    <p>Please choose your new password:</p>

    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(['id' => 'reset-password-form']); ?>
                <?php //$form->field($model, 'password')->passwordInput() ?>
                <?=Html::input('password','password','',['class'=>'form-control'])?>
                <br />
                <div class="form-group">
                    <?= Html::submitButton('Save', ['class' => 'btn btn-primary']) ?>
                </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
