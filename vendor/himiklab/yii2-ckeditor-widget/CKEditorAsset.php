<?php
/**
 * @link https://github.com/himiklab/yii2-ckeditor-widget
 * @copyright Copyright (c) 2014 HimikLab
 * @license http://opensource.org/licenses/MIT MIT
 */

namespace himiklab\ckeditor;

use yii\web\AssetBundle;

class CKEditorAsset extends AssetBundle
{
    public $sourcePath = '@vendor/ckeditor/ckeditor';

    public $js = [
        'ckeditor.js',
        'adapters/jquery.js'
    ];

    public $depends = [
        'yii\web\JqueryAsset'
    ];
}
