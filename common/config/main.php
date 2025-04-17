<?php
return [
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'timeZone' => 'Asia/Tashkent',
    'components' => [
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
        ],
        'cache' => [
            'class' => \yii\caching\FileCache::class,
        ],
        'telegram' => [
            'class' => 'aki\telegram\Telegram',
            'botToken' => '6686082454:AAHePqzPHAzvR5NMtpY6BfuwMnM3Cw9HKyI',
        ],
        'ikAmoCrm' => [
            'class' => 'common\components\AmoCrmClient',
        ],
    ],
];
