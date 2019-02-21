<?php
return [
    'components' => [
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => getenv('CONNECT_DB' , 'mysql:host=localhost;dbname=midb'),
            'username' => getenv('DB_USER','usuario'),
            'password' => getenv('DB_PASSWORD','clave'),
            'charset' => 'utf8',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'viewPath' => '@common/mail',
            'transport' => [
                'class' => 'Swift_SmtpTransport',
                'host' => self::env('SMTP_HOST'),
                'username' => self::env('SMTP_USER'),
                'password' => self::env('SMTP_PASSWORD'),
                'port' => self::env('SMTP_PORT', 25),
                'encryption' => self::env('SMTP_ENCRYPTION', null),
            ],
        ],

    ],
];
