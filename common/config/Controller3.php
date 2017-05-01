<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace common\config;

use yii\web\Controller;

class Controller3 extends Controller2 {

    public function init() {
        parent::init();
        $language = 'en';
        \Yii::$app->language = $language;
    }

}
