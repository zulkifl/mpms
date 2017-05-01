<?php

return [
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
		'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => false,
           'authTimeout' => 1800, //Seconds **
        ], 
//        'i18n' => [
//            'translations' => [
//                '*' => [
//                    'class' => 'yii\i18n\DbMessageSource',
//                    'forceTranslation' => true,
//                     'enableCaching' => true, 'cachingDuration' => 60 * 60 * 2,
//                ],
//                'app' => ['class' => 'yii\i18n\DbMessageSource'],
//            ],
//        ],
    ],
];
