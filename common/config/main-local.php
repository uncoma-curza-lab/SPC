<?php

return [
    'components' => [
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => getenv('CONNECT_DB')? getenv('CONNECT_DB') : 'mysql:host=localhost;dbname=aulasyprogramas',
            'username' => getenv('DB_USER') ? getenv('DB_USER') : 'curza',
            'password' => getenv('DB_PASSWORD') ? getenv('DB_PASSWORD') : 'curza' ,
            'charset' => 'utf8',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'viewPath' => '@common/mail',
            'transport' => [
                'class' => 'Swift_SmtpTransport',
                'host' => getenv('SMTP_HOST'),
                'username' => getenv('SMTP_USER'),
                'password' => getenv('SMTP_PASSWORD'),
                'port' => getenv('SMTP_PORT', 25),
                'encryption' => getenv('SMTP_ENCRYPTION', null),
            ],
        ],

    ],
];
