<?php
/* @var $this yii\web\View */

$this->title = \Yii::t('app', \Yii::$app->params['name']);
?>
<div class="site-index">

    <div class="jumbotron">
        <h1><?= \Yii::t('app', 'Welcome') ?></h1>

        <p class="lead"><?= \Yii::t('app', $this->title) . ' ' . \Yii::t('app', 'Admin Panel'); ?></p>

    </div>
</div>
