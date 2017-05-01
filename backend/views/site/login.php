<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

$this->title = 'Login';
//$this->params['breadcrumbs'][] = $this->title;
?>
<br>
<br>
<div class="site-login">
    

    <p>Please fill out the following fields to login:</p>
     <?php if (Yii::$app->session->getFlash('s_mesage')) { ?>
        <div class="alert alert-success">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            <?= Yii::$app->session->getFlash('s_mesage'); ?>
        </div>
        <?php
    }
    ?>
               <?php if (Yii::$app->session->getFlash('s_error')) { ?>
        <div class="alert alert-danger">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            <?= Yii::$app->session->getFlash('s_error'); ?>
        </div>
        <?php
    }
    ?>
    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>
                <?= $form->field($model, 'username') ?>
                <?= $form->field($model, 'password')->passwordInput() ?>
                <?= $form->field($model, 'rememberMe')->checkbox() ?>
            <div style="color:#999;margin:1em 0">
                    If you forgot your password you can <?= Html::a('reset it', ['site/requestpassword']) ?>.
                   
                </div>
                <div class="form-group">
                    <?= Html::submitButton('Login', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
                </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
