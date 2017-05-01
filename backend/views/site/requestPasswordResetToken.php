<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \\common\models\PasswordResetRequestForm */

$this->title = 'Request password reset';
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-request-password-reset">
   <div class="row">
   <div class="col-md-3"></div>
   <div class="col-md-4 business_box" style="padding-left: 5%">
    <h1 style="font-size:20px;"><?= Html::encode($this->title) ?></h1>
<?php if (Yii::$app->session->getFlash('s_mesage')) { ?>
        <div class="alert alert-success">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            <?= Yii::$app->session->getFlash('s_mesage'); ?>
        </div>
    <?php } ?>
    <p>Please fill out your email. A link to reset password will be sent in email.</p>

    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(['id' => 'request-password-reset-form']); ?>
                <?= $form->field($model, 'email') ?>
                <div class="form-group">
                    <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
                </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
    </div>
    <div class="col-md-5"></div>
    </div>
</div>
<style>
#passwordresetrequestform-email { width: 155%; border-radius: 0px}
.help-block-error { width:142%;}
</style>