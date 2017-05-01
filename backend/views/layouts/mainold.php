<?php

use backend\assets\AppAsset;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use yii\bootstrap\Dropdown;
use common\models\User;

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
            <?php
            NavBar::begin([
                'brandLabel' => \Yii::t('app', \Yii::$app->params['name']),
                'brandUrl' => Yii::$app->homeUrl,
                'options' => [
                    'class' => 'navbar-inverse navbar-fixed-top',
                ],
            ]);
            $menuItems = [
                ['label' => Yii::t('app', 'Home'), 'url' => ['/site/index']],
            ];
            if (Yii::$app->user->isGuest) {
                
            } else {
                
            }
            if (Yii::$app->user->isGuest) {
                $menuItems[] = ['label' => Yii::t('app', 'Login'), 'url' => ['/site/login']];
            } else {
                $menuItems[] = [
                    'label' => Yii::t('app', 'Logout') . ' (' . Yii::$app->user->identity->username . ')',
                    'url' => ['/site/logout'],
                    'linkOptions' => ['data-method' => 'post']
                ];
            }
            echo Nav::widget([
                'options' => ['class' => 'navbar-nav navbar-right'],
                'items' => $menuItems,
            ]);
            NavBar::end();
            ?>
            <?php
            if (!Yii::$app->user->isGuest) {
                $user = User::findByUsername(\Yii::$app->user->identity->username);
                if ($user->isAdmin) {
                    ?>
                    <div class="row">
                        <div class="col-md-2" style="margin-top: 6%; padding-left: 2%;">
                            <div style="border:#CCCCCC 1px solid; padding-left: 6%;" >
                                <div class="row">
                                    <div class="col-md-12">
                                        <h4><?= Yii::t('app', 'Manage') ?></h4>
                                        <a href="<?= Yii::$app->urlManager->createUrl("/site/managebusiness"); ?>"><?= Yii::t('app', 'Business') ?></a><br>
                                        <a href="<?= Yii::$app->urlManager->createUrl("/site/managefranchise"); ?>"><?= Yii::t('app', 'Franchise') ?></a><br>
                                        <a href="<?= Yii::$app->urlManager->createUrl("/site/managebusinessdirectory"); ?>"><?= Yii::t('app', \Yii::$app->params['businessDirectory']) ?></a><br>
                                        <a href="<?= Yii::$app->urlManager->createUrl("/site/managecommunity"); ?>"><?= Yii::t('app', 'Discussions') ?></a><br>
                                        <a href="<?= Yii::$app->urlManager->createUrl("/site/managecomments"); ?>"><?= Yii::t('app', 'Comments') ?></a>
                                    </div>
                                </div>

                            </div>
                            <div style="border:#CCCCCC 1px solid; padding-left: 6%;" >
                                <div class="row">
                                    <div class="col-md-12">
                                        <h4><?= Yii::t('app', 'Manage Dropdowns') ?></h4>

                                        <a href="<?= Yii::$app->urlManager->createUrl("/category/index"); ?>"><?= Yii::t('app', 'Industry') ?></a>
                                        <br>
                                        <a href="<?= Yii::$app->urlManager->createUrl("/subcategory/index"); ?>"><?= Yii::t('app', 'Industry Segment') ?></a>
                                        <br>
                                        <a href="<?= Yii::$app->urlManager->createUrl("/businessdropdown/index"); ?>"><?= Yii::t('app', 'Business') ?></a>
                                        <br>
                                        <a href="<?= Yii::$app->urlManager->createUrl("/cities/index"); ?>"><?= Yii::t('app', 'Cities') ?></a><br>
                                        <a href="<?= Yii::$app->urlManager->createUrl("/countries/index"); ?>"><?= Yii::t('app', 'Countries') ?></a>
                                    </div>
                                </div>

                            </div>

                            <div style="border:#CCCCCC 1px solid; padding-left: 6%;" >
                                <div class="row">
                                    <div class="col-md-12">
                                        <h4><?= Yii::t('app', 'Manage Help') ?></h4>
                                        <a href="<?= Yii::$app->urlManager->createUrl("/faq/index"); ?>"><?= Yii::t('app', 'FAQ') ?></a><br>
                                        <a href="<?= Yii::$app->urlManager->createUrl("/needhelp/index"); ?>"><?= Yii::t('app', 'Need Help') ?></a>

                                    </div>
                                </div>
                            </div>
                            <div style="border:#CCCCCC 1px solid; padding-left: 6%;" >
                                <div class="row">
                                    <div class="col-md-12">
                                        <h4><?= Yii::t('app', 'Manage Users') ?></h4>
                                        <a href="<?= Yii::$app->urlManager->createUrl("/user/index"); ?>"><?= Yii::t('app', 'Users') ?></a>

                                    </div>
                                </div>
                            </div>

                            <div style="border:#CCCCCC 1px solid; padding-left: 6%;" >
                                <div class="row">
                                    <div class="col-md-12">
                                        <h4><?= Yii::t('app', 'Manage Contents') ?></h4>
                                        <a href="<?= Yii::$app->urlManager->createUrl("/banar/index"); ?>"><?= Yii::t('app', 'Banners') ?></a><br>
                                        <a href="<?= Yii::$app->urlManager->createUrl("/adv/index"); ?>"><?= Yii::t('app', 'Advertisements') ?></a><br>
                                        <a href="<?= Yii::$app->urlManager->createUrl("/textads/index"); ?>"><?= Yii::t('app', 'Text Advertisements') ?></a><br>
                                        <a href="<?= Yii::$app->urlManager->createUrl("/contactus/index"); ?>">Feedback</a> <br>
                                        <a href="<?= Yii::$app->urlManager->createUrl("/getfinanced/index"); ?>">Manage Get Financed</a> <br>
                                        <a href="<?= Yii::$app->urlManager->createUrl("/sourcemessage/index"); ?>"><?= Yii::t('app', 'Translation') ?></a><br>

                                        <?=
                                        Html::a(Yii::t('app', 'Contact Us'), ['/settings/view', 'id' => 1]
                                        )
                                        ?>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <?php
                    }
                }
                ?>
                <div class="col-md-9">
                    <div class="container">
                        <?=
                        Breadcrumbs::widget([
                            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                        ])
                        ?>

                        <?= $content ?>
                    </div>
                </div>
            </div>


        </div>

        <footer class="footer">
            <div class="container">
                <p class="pull-left">&copy; <?= \Yii::t('app', \Yii::$app->params['name']) ?> <?= date('Y') ?></p>
                <p class="pull-right"></p>
            </div>
        </footer>

        <?php $this->endBody() ?>
    </body>
</html>
<?php $this->endPage() ?>
