<?php

return [
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host=120.27.33.23;dbname=my_web',
    'username' => 'root',
    'password' => 'mxker5120',
    'tablePrefix' => 'my_',
    'charset' => 'utf8',
    'enableSchemaCache' => YII_ENV == 'dev' ? false : true, // 表结构缓存
    'schemaCacheDuration' => 86400,
];
