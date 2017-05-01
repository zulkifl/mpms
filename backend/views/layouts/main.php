<?php

use yii\helpers\Html;
use yii\widgets\Breadcrumbs;
use backend\assets\AdminLTEAsset;
use backend\widgets\Alert;
use common\config\View2;
use yii\widgets\Pjax;
use common\config\Options;
use common\config\Controller2;

/* @var $this yii\web\View */
/* @var $content string */

AdminLTEAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="<?= Yii::$app->charset ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon" />
        <?= Html::csrfMetaTags() ?>
        <title><?= Html::encode(\Yii::$app->params['name'] . ' - ' . $this->title) ?></title>
        <?php $this->head() ?>
    </head>
    <body class="hold-transition sidebar-mini skin-purple-light ">
        <style>
            .kv-container-from{
                padding: 0px;
                border: 0px #ffffff none;
            }
            .kv-container-to{
                padding: 0px;
                border: 0px #ffffff none;
            }
        </style>
        <?php $this->beginBody() ?>
        <div class="wrapper">
            <header class="main-header">
                <!-- Logo -->
                <a href="<?php ?>" class="logo">
                    <!-- mini logo for sidebar mini 50x50 pixels -->
                    <span class="logo-mini"><b><?= \Yii::$app->params['ProjectShortName']; ?></b></span>
                    <!-- logo for regular state and mobile devices -->
                    <span class="logo-lg"><b><?= \Yii::$app->params['name']; ?></b></span>
                </a>
                <!-- Header Navbar: style can be found in header.less -->
                <nav class="navbar navbar-static-top" role="navigation">
                    <!-- Sidebar toggle button-->
                    <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                        <span class="sr-only">Toggle navigation</span>
                    </a>

                    <!--                    <div class="pull-left">
                                            <h4 style="color: white; font-size: 20px"><b><?= Yii::$app->params['CompanyName'] ?></b></h4>
                                        </div>-->
                    <div class="navbar-custom-menu">
                        <ul class="nav navbar-nav">

                            <!-- User Account: style can be found in dropdown.less -->
                            <?php if (!Yii::$app->user->isGuest) { ?>
                                <li class="dropdown user user-menu">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                        <?php
                                        $user = \common\models\User::findOne(Yii::$app->user->id);
                                        $image = "images/user.png";
                                        $name = \Yii::$app->user->identity->username;
                                        if ($user != null) {
                                            $name = $user->l_name != "" ? $name = ($user->f_name . ' ' . $user->l_name) : $user->username;
                                            $image = $user->pic == "" ? "images/user.png" : @$user->pic;
                                        }
                                        ?>
                                        <img src="<?= Options::getFrontendAddress() . $image ?>" class="user-image" alt="User Image">
                                        <span class="hidden-xs"><?= $name; ?></span>
                                    </a>
                                    <ul class="dropdown-menu">
                                        <!-- Menu Footer-->
                                        <li class="user-footer">
                                            <div class="pull-left">
                                                <?=
                                                $url = Html::a('Reset Password', ['/site/requestpasswordreset'], ['class' => 'btn btn-default btn-flat', 'data-method' => 'post']);
                                                ?>
                                            </div>
                                            <div class="pull-right">
                                                <?=
                                                $url = Html::a('Sign out', ['/site/logout'], ['class' => 'btn btn-default btn-flat', 'data-method' => 'post']);
                                                ?>
                                            </div>
                                        </li>
                                    </ul>
                                </li>
                            <?php } ?>
                            <!-- Control Sidebar Toggle Button -->
                        </ul>
                    </div>
                </nav>
            </header>

            <?php
            $Category = Options::getOptionPName(Controller2::CATEGORY);
            $Country = Options::getOptionPName(Controller2::COUNTRY);
            $city = Options::getOptionPName(Controller2::CITY);

            if (!Yii::$app->user->isGuest) {
                $sideBar = [
                    [
                        'id' => 0, 'url' => '', 'class' => "header", 'name' => 'MAIN NAVIGATION', 'visible' => true
                    ],
                    [
                        'id' => 100, 'url' => \Yii::$app->urlManager->createUrl("/site/index"), 'class' => "fa fa-dashboard", 'name' => 'Dashboard', 'visible' => true
                    ],
                    [
                        'id' => 200, 'url' => '#', 'class' => "fa fa-tasks", 'name' => Yii::t('app', 'Managers'), 'visible' => true, 'SubMenu' => [
                            ['id' => 201, 'url' => \Yii::$app->urlManager->createUrl("/category/index"), 'class' => "glyphicon glyphicon-list", 'name' => $Category, 'visible' => true],
                            ['id' => 205, 'url' => \Yii::$app->urlManager->createUrl("/cities/index"), 'class' => "glyphicon glyphicon-list", 'name' => $city, 'visible' => true],
                            ['id' => 202, 'url' => \Yii::$app->urlManager->createUrl("/countries/index"), 'class' => "glyphicon glyphicon-list", 'name' => $Country, 'visible' => true],
                            ['id' => 203, 'url' => \Yii::$app->urlManager->createUrl("/serviceprovider/index"), 'class' => "glyphicon glyphicon-list", 'name' => Yii::t('app', 'Service Providers'), 'visible' => true],
                            ['id' => 204, 'url' => \Yii::$app->urlManager->createUrl("/user/index"), 'class' => "glyphicon glyphicon-list", 'name' => Yii::t('app', 'Users'), 'visible' => Yii::$app->user->identity->is_admin == '1'],
                        ]
                    ],
                ];
            }
            ?>
            <?php if (!Yii::$app->user->isGuest) { ?>
                <!-- ---------------  Side menu  --------------------->
                <aside class="main-sidebar">
                    <section class="sidebar">
                        <ul class="sidebar-menu">
                            <?php
                            foreach ($sideBar as $value) {
                                $active = '';
                                if (isset($this->context->mainMenu)) {
                                    if ($this->context->mainMenu == $value['id']) {
                                        $active = ' active ';
                                    }
                                }
                                if ($value['visible'] == true) {
                                    if ($value['url'] == '') {
                                        echo '<li class="' . $value['class'] . '">' . $value['name'] . '</li>';
                                    } else {
                                        $mainClass = "";
                                        if ($value['url'] == '#') {
                                            $mainClass = 'treeview';
                                        }

                                        echo"<li class='$mainClass $active'>";
                                        echo '<a href="' . $value['url'] . '">';
                                        echo '<i class="' . $value['class'] . '"></i><span>' . $value['name'] . "</span>";
                                        if ($value['url'] == '#') {
                                            echo '<i class="fa fa-angle-left pull-right"></i>';
                                        }
                                        echo '</a>';

                                        if ($value['url'] == '#') {
                                            $subMenu = $value['SubMenu'];
                                            if (count($subMenu) > 0) {
                                                echo '<ul class="treeview-menu">';

                                                foreach ($subMenu as $value2) {
                                                    $subActive = '';
                                                    if (isset($this->context->submenu)) {
                                                        if ($this->context->submenu == $value2['id']) {
                                                            $subActive = ' active ';
                                                        }
                                                    }
                                                    if ($value2['visible'] == true) {
                                                        echo"<li class='$subActive'>";
                                                        echo '<a href="' . $value2['url'] . '">';
                                                        echo '<i class="' . $value2['class'] . '"></i><span>' . $value2['name'] . "</span>";
                                                        echo '</a>';
                                                        echo '</li>';
                                                    }
                                                }
                                                echo '</ul>';
                                            }
                                        }
                                        echo'</li >';
                                    }
                                }
                            }
                            ?>
                        </ul>
                    </section>
                    <!-- /.sidebar -->
                </aside>
            <?php } ?>
            <div class="content-wrapper">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h2><?= $this->title; ?></h2>
                    <?=
                    Breadcrumbs::widget([
                        'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                    ])
                    ?>
                </section>

                <?= Alert::widget() ?>
                <section class="content">
                    <?= $content ?>
                </section>
            </div>
        </div>

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <div class="tab-content">
                <div class="tab-pane" id="control-sidebar-home-tab">
                </div>
            </div>
        </aside>

        <div class="control-sidebar-bg"></div>

        <footer class="footer">
            <div class="container">
                <p class="pull-left">&copy; <?= Yii::$app->params['CompanyName'] ?> <?= date('Y') ?></p>

            </div>
        </footer>

        <?php $this->endBody() ?>
    </body>
</html>
<?php $this->endPage() ?>
