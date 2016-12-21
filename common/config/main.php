<?php
$params = require __DIR__ . '/params.php';

return [
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'language' => 'zh-CN',
    'timeZone'=>'Asia/Chongqing',
    'components' => [
        'redis' => [
            'class' => 'yii\redis\Connection',
            'hostname' => '192.168.1.200',
            'port' => 6379,
            'database' => 0,
        ],
        'db' => require __DIR__ . '/db.php',
    ],
    'params' => $params,
];