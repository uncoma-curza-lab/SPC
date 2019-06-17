<?php
use \yii\web\UrlRule;

$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-backend',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    'name' => 'Administrador de programas',
    'bootstrap' => ['log'],
    'modules' => [

    ],
    'components' => [
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-backend', 'httpOnly' => true],
        ],
        'request' => [
            'csrfParam' => '_csrf-backend',
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
            ]
        ],

        'session' => [
            // this is the name of the session cookie used for login on the backend
            'name' => 'advanced-backend',
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
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        
        /*'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'enableStrictParsing' => true,
            
            'rules' => [
                '/' => 'site/index',
                '<controller:(carrera|departamento)>/<id:\d+>/<action:(view|create|update|delete)>' => '<controller>/<action>',
                '<controller:(carrera|departamento|asignatura|status|plan|rol|user|perfil|designacion)>/<action:(index)>' => '<controller>/<action>', 
                //'carrera' => 'carrera/index',
                //'departamento' => 'departamento/index',
                //'carrera/<id:\d+>' => 'carrera/view',
                'api' => 'api',
                'inicio' => 'site/index',
                'login' => 'site/login',
                //[
                //    'class' => 'yii\rest\UrlRule',
                //    'controller' => 'site',
                //    'patterns' => [
                //        'GET index' => 'index'
                //    ]
                //],
                ['class' => 'yii\rest\UrlRule', 'controller' => 'usuario/index'],
            ],
        ],*/
        
    ],
    'params' => $params,
];
