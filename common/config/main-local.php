<?php

return [
    'components' => [
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => getenv('CONNECT_DB')? getenv('CONNECT_DB') : 'mysql:host=mysql;dbname=curza',
            'username' => getenv('DB_USER') ? getenv('DB_USER') : 'curza',
            'password' => getenv('DB_PASSWORD') ? getenv('DB_PASSWORD') : 'curza' ,
            'charset' => 'utf8',
        ],
        

    ],
];
