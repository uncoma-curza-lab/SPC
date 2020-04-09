<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-frontend',
    'name' => 'Programas CURZA',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'frontend\controllers',
    'components' => [
        'GenerateNotification' => [
            'class' => 'frontend\components\GenerateNotification'
        ],    
        'formatter' => [
            'dateFormat' => 'dd/MM/yyyy H:mm:ss',
            'decimalSeparator' => ',',
            'thousandSeparator' => ' ',
            'currencyCode' => 'ARS',
        ],
        'request' => [
            'csrfParam' => '_csrf-frontend',
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => false,
            'identityCookie' => ['name' => '_identity-frontend', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the frontend
            //'name' => 'advanced-frontend',
            //'class' => 'yii\web\DbSession',
            'timeout' => 5*3600, // 5 horas
            'class' => 'yii\web\DbSession',
		    'sessionTable' => 'user_session',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 0 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'categories' => ['estado-programa'],
                    'logFile' => '@app/runtime/logs/estado-programa/registro.log',
                    'levels' => ['info'],
                    'prefix' => function ($message) {
                        $user = Yii::$app->has('user', true) ? Yii::$app->get('user') : null;
                        $userID = $user ? $user->getId(false) : '-';
                        return "[$userID] ";
                    },
                    'maxFileSize' => 1024 * 2,
                    'maxLogFiles' => 8,
                    'logVars' => ['_SESSION'],
                ],
                [
                    'class' => 'yii\log\FileTarget',
                    'categories' => ['estado-programa'],
                    'logFile' => '@app/runtime/logs/estado-programa/error.log',
                    'levels' => ['error', 'warning'],
                    'prefix' => function ($message) {
                        $user = Yii::$app->has('user', true) ? Yii::$app->get('user') : null;
                        $userID = $user ? $user->getId(false) : '-';
                        return "[$userID] ";
                    },
                    'maxFileSize' => 1024 * 2,
                    'maxLogFiles' => 8,
                    'logVars' => ['_SESSION','_GET','_POST'],
                ],
                // LOGS Mi-Programa
                [
                    'class' => 'yii\log\FileTarget',
                    'categories' => ['miprograma'],
                    'logFile' => '@app/runtime/logs/miprograma/registro.log',
                    'levels' => ['info'],
                    'prefix' => function ($message) {
                        $user = Yii::$app->has('user', true) ? Yii::$app->get('user') : null;
                        $userID = $user ? $user->getId(false) : '-';
                        return "[$userID] ";
                    },
                    'maxFileSize' => 1024 * 2,
                    'maxLogFiles' => 8,
                    'logVars' => ['_SESSION'],
                ],
                [
                    'class' => 'yii\log\FileTarget',
                    'categories' => ['miprograma'],
                    'logFile' => '@app/runtime/logs/miprograma/error.log',
                    'levels' => ['error', 'warning'],
                    'prefix' => function ($message) {
                        $user = Yii::$app->has('user', true) ? Yii::$app->get('user') : null;
                        $userID = $user ? $user->getId(false) : '-';
                        return "[$userID] ";
                    },
                    'maxFileSize' => 1024 * 2,
                    'maxLogFiles' => 8,
                    'logVars' => ['_SESSION','_GET','_POST'],
                ],
            ],
        ],
        /*'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['info'],
                    'categories' => ['orders'],
                    'logFile' => '@app/runtime/logs/Orders/requests.log',
                    'maxFileSize' => 1024 * 2,
                    'maxLogFiles' => 20,
                ],
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['info'],
                    'categories' => ['pushNotifications'],
                    'logFile' => '@app/runtime/logs/Orders/notification.log',
                    'maxFileSize' => 1024 * 2,
                    'maxLogFiles' => 50,
                ],
            ],
        ],*/
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
 
        /*
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
            ],
        ],
        */
    ],
    'params' => $params,
];
