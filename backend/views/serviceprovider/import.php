<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;

/* @var $this yii\web\View */
/* @var $model frontend\models\Trip */
/* @var $form yii\widgets\ActiveForm */


    $this->title = 'Import Service Providers';

$this->params['breadcrumbs'][] = ['label' =>'Service Providers' , 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="trip-create">

    <div class="trip-form">

        <?php
        $form = ActiveForm::begin(['type' => ActiveForm::TYPE_VERTICAL, 'options' => ['enctype' => 'multipart/form-data']]);
        ?>
        <?=
        Form::widget([
            'model' => $model,
            'form' => $form,
            'columns' => 1,
            'attributes' => [
                'file' => [
                    'type' => Form::INPUT_FILE,
                ]
            ]
                ]
        );
        ?>
        <div class="form-group">
            <?= Html::submitButton('Import', ['class' => 'btn btn-primary']) ?>
        </div>

        <?php ActiveForm::end(); ?>
    </div>
    
    <a href="<?= common\config\Options::getFrontendAddress()."uploads/SP.xls"?>">Download Excel Template for upload</a>
</div>