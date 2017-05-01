<?php

$params = array_merge(
        require(__DIR__ . '/../../common/config/params.php'), 
        require(__DIR__ . '/../../common/config/params-local.php'), 
        require(__DIR__ . '/params.php'), 
        require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-backend',
    'basePath' => dirname(__DIR__),
    'language' => 'ar',
    'sourceLanguage' => 'en-US',
    'controllerNamespace' => 'backend\controllers',
    'bootstrap' => ['log'],
    'modules' => [],
    'components' => [
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'i18n' => [
            'translations' => [
                //'app' => ['class' => 'yii\i18n\DbMessageSource'],
//                '*' => [
//                    'class' => 'yii\i18n\DbMessageSource',
//                    'forceTranslation' => true,
//                     'enableCaching' => true, 'cachingDuration' => 60 * 60 * 2,
//                ]
            ],
        ],
    ],
    'params' => $params,
];
