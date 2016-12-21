<?php
$params = require(__DIR__ . '/params.php');

return [
    'id' => 'app-console',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'console\controllers',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\MemCache',
            'keyPrefix' => 'exconsole',
            'servers' => [
                [
                    'host' => '127.0.0.1',
                    'port' => 11211,
                    'weight' => 90,
                ],
            ],
        ],
        'log' => [
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
