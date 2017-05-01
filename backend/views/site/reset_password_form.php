<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\BaseHtml;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

$this->title = 'Password Reset';
//$this->params['breadcrumbs'][] = $this->title;
?>
<br>
<br>
<div class="site-login">


    <p>Please fill out the following fields :</p>
    <div class="row">
        <div class="col-lg-5">


            <div class="row">
                <div class="col-lg-8">
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
                    <?php $form = ActiveForm::begin(['action' => Yii::$app->urlManager->createUrl('/site/rest_pass')]); ?>

                    <?= Html::input('text', 'email', '', ['class' => 'form-control']) ?>
                    <br>
                    <?= Html::submitButton('Submit', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
                </div>



                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
