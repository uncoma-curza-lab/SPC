<?php
return [
    'id' => 'app-backend-tests',
    'components' => [
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=localhost;dbname=test',
            'username' => getenv('DB_USER') ? getenv('DB_USER') : 'curza',
            'password' => getenv('DB_PASSWORD') ? getenv('DB_PASSWORD') : 'curza' ,
            'charset' => 'utf8',
        ],
        'assetManager' => [
            'basePath' => __DIR__ . '/../web/assets',
        ],
        'urlManager' => [
            'showScriptName' => true,
        ],
    ],
];
