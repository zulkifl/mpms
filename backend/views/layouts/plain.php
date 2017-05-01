<?php

use yii\helpers\Html;
use yii\widgets\Breadcrumbs;
use frontend\assets\SigninAsset;
use frontend\widgets\Alert;
use common\config\View2;

/* @var $this yii\web\View */
/* @var $content string */

SigninAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="<?= Yii::$app->charset ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?= Html::csrfMetaTags() ?>
        <title><?= Html::encode(\Yii::$app->params['ProjectName'] . ' - ' . $this->title) ?></title>
        <?php $this->head() ?>
    </head>
    <body >
        <?php $this->beginBody() ?>
        <?= $content ?>
        <?php $this->endBody() ?>
    </body>
</html>
<?php $this->endPage() ?>
