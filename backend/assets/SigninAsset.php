<?php

/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace backend\assets;

use yii\web\AssetBundle;

class SigninAsset extends AssetBundle {

    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [

        'css/bootstrap.min.css',
        '//maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css',
        '//code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css',
        'dist/css/AdminLTE.min.css',
        'plugins/iCheck/flat/blue.css',
        'css/site.css',
        'css/login.css'
    ];
    public $js = [

        '//code.jquery.com/ui/1.11.4/jquery-ui.min.js',
        'js/bootstrap/bootstrap.min.js',
        'plugins/iCheck/icheck.min.js'
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];

}
