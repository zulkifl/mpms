
<?php
/* @var $this yii\web\View */

use yii\helpers\Html;

$this->title = \Yii::$app->params['name'];
?>
<?= Html::a(Yii::t('app', 'List'), ['index'], ['class' => 'btn btn-primary']) ?>

<div class="site-index">
    <h3><?= $model['name'] ?></h3>
   
    <hr>
    <div class="row">
        <div class="col-md-2"><b>Function Name</b></div>
        <div class="col-md-4"><?= $model['function'] ?></div>
        <div class="col-md-2"><b>Method</b></div>
        <div class="col-md-2"><?= $model['method'] ?></div>
    </div>
    <hr>

    <div class="row">
        <div class="col-md-2"><b>Description</b></div>
        <div class="col-md-10"><?= $model['description'] ?></div>
    </div>
    <hr>
    <div class="row">
        <div class="col-md-6">

            <div class="row"><div class="col-md-11"><b>Parameters</b></div></div>
            <?php foreach ($model['parameters'] as $val) { ?>
                <div class="row">
                    <div class="col-md-2"></div>
                    <div class="col-md-3"><?= $val[0] ?></div>
                    <div class="col-md-2"><?= $val[1] == 'O' ? 'Optional' : 'Mandatory' ?></div>
                    <div class="col-md-5"><?= isset($val[2]) ? $val[2] : '' ?></div>
                </div>
            <?php } ?>
        </div>

        <div class="col-md-6">

            <div class="row"><div class="col-md-11"><b>Response</b></div></div>
            <?php foreach ($model['replay'] as $val) { ?>
                <div class="row">
                    <div class="col-md-2"></div>
                    <div class="col-md-10"><?= $val ?></div>
                </div>
            <?php } ?>
        </div>


    </div>

</div>
