<?php

use yii\helpers\Html;
use yii\widgets\Breadcrumbs;
use backend\assets\SigninAsset;
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
        <title><?= Html::encode(\Yii::$app->params['name'] . ' - ' . $this->title) ?></title>
        <?php $this->head() ?>
    </head>
    <body >
        <?php $this->beginBody() ?>
        <div class="row">
            <div class="col-md-5">
                <div class="row">
                    <br>
                    <br>
                    <div class="login-logo">
                        <a href="#"><b><?= \Yii::$app->params['name']; ?></b></a>
                    </div>
                    <?= Alert::widget() ?>
                    <div class="login-box-body">
                        <?= $content ?>
                    </div>
                </div>
            </div>
            <div class="col-md-7">
                <br>
                <br>
                <image  class="img-responsive" src="<?= Yii::$app->urlManager->getBaseUrl() ?>/images/main-side.jpg">
            </div>
        </div>
        <?php $this->endBody() ?>
    </body>
</html>
<?php $this->endPage() ?>
