<?php

use api\assets\AppAsset;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;

/* @var $this \yii\web\View */
/* @var $content string */

AppAsset::register($this);
?>
<?php $this->beginPage() ?>

<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="<?= Yii::$app->charset ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?= Html::csrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?></title>
<?php $this->head() ?>
    </head>
    <body>
            <?php $this->beginBody() ?>
        <div class="wrap">
            <div class = "pull-right">
                <?= 
                    $url = Html::a('Sign out', ['/site/logout'], ['class' => 'btn btn-default btn-flat', 'data-method' => 'post']);
                ?>
            </div>
            <?php
            NavBar::begin([
                'brandLabel' => \Yii::$app->params['name'],
                'brandUrl' => Yii::$app->homeUrl,
                'options' => [
                    'class' => 'navbar-inverse navbar-fixed-top',
                ],
            ]);
            $menuItems = [
                ['label' => 'Home', 'url' => ['/site/index']],
                ['label' => 'Logout', 'url' => ['/site/logout'],'linkOptions' => ['data-method' => 'post'],'visible'=>  !Yii::$app->user->isGuest],
            ];
            echo Nav::widget([
                'options' => ['class' => 'navbar-nav navbar-right'],
                'items' => $menuItems,
            ]);
            NavBar::end();
            ?>
           

            <div class="container">
                <?=
                Breadcrumbs::widget([
                    'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                ])
                ?>
<?= $content ?>
            </div>
        </div>

        <footer class="footer">
            <div class="container">
                <p class="pull-left">&copy; <?= \Yii::$app->params['name']; ?> <?= date('Y') ?></p>

            </div>
        </footer>

<?php $this->endBody() ?>
    </body>
</html>
<?php $this->endPage() ?>
