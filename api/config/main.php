<?php
$params = require __DIR__ . '/params.php';

$config = [
    'id' => 'myexpress-api',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'api\controllers',
    'bootstrap' => ['log'],
    'defaultRoute' => 'api/error',
    'timeZone'=>'Asia/Chongqing',
    'components' => [
        'request' => [
            'enableCsrfValidation' => false,
        ],
        'cache' => [
            'class' => 'yii\caching\MemCache',
            'keyPrefix' => 'exapi',
            'servers' => [
                [
                    'host' => '127.0.0.1',
                    'port' => 11211,
                    'weight' => 90,
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'api/error',
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

    ],
    'params' => $params,
];

return $config;