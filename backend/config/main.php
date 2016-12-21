<?php
$params = require __DIR__ . '/params.php';

$config = [
    'id' => 'myexpress-backend',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    'bootstrap' => ['log'],
    'defaultRoute' => 'site/login',
    'components' => [
        'request' => [
            'cookieValidationKey' => 'mebcookie',
        ],
        'cache' => [
            'class' => 'yii\caching\MemCache',
            'keyPrefix' => 'exb',
            'servers' => [
                [
                    'host' => '127.0.0.1',
                    'port' => 11211,
                    'weight' => 90,
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'session' => [
            'name' => 'mebss',
            'timeout' => 1800,
            'cookieParams' => ['lifetime' => 0, 'path' => '/', 'domain' => ''],
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
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                "<controller:\w+>/<action:\w+>" => "<controller>/<action>",
            ],
        ],
        'authAdmin' => [
            'class' => 'backend\components\AuthAdmin',
            'allowActions' => [
                'site/*',
            ],
        ],

    ],
    'params' => $params,
];

if (YII_ENV_DEV == 'dev') {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        'allowedIPs' => ['127.0.0.1', '::1', '192.168.111.*'],
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        'allowedIPs' => ['127.0.0.1', '::1', '192.168.111.*'],
    ];
}
return $config;