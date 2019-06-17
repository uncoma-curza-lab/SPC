<?php
use \yii\web\UrlRule;

$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-api',
    'basePath' => dirname(__DIR__),
    //'controllerNamespace' => 'api\controllers',
    //'name' => 'Administrador de programas',
    'bootstrap' => ['log'],
    'modules' => [
        'v1' => [
            'basePath' => '@app/modules/v1',
            'class' => 'api\modules\v1\Module'
        ],
    ],
    
    'components' => [
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => false,
            //'identityCookie' => ['name' => '_identity-api', 'httpOnly' => true],
        ],
        'request' => [
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
            ]
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        
        'urlManager' => [
            'enablePrettyUrl' => true,
            'enableStrictParsing' => true,
            'showScriptName' => false,
            'rules' => [
                'ping' => 'site/ping',
                //['class' => 'yii\rest\UrlRule', 'controller' => 'asignatura'],
                [
                    'class' => 'yii\rest\UrlRule', 
                    'controller' => [
                        'v1/asign'=> 'v1/asignatura'
                    ],
                    'pluralize' => false,
                    'tokens' => [
                        '{id}' => '<id:\\w+>'
                    ],
                    'extraPatterns' => [
                        'GET asign/<id>' => 'asignatura/buscar',
                    ],
                    'except' => ['delete','create','update']
                ],
                [
                    'class' => 'yii\rest\UrlRule', 
                    'controller' => [
                        'v1/dpto'=> 'v1/departamento'
                    ],
                ],
                [
                    'class' => 'yii\rest\UrlRule', 
                    'controller' => [
                        'v1/carrera'=> 'v1/carrera'
                    ],
                ],
                [
                    'class' => 'yii\rest\UrlRule', 
                    'controller' => [
                        'v1/plan'=> 'v1/plan'
                    ],
                ],
                //'GET asign/buscar/<id:\d+>' => 'asignatura/buscar',
                //'GET asign/index' => 'asignatura/index',
                /*[
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'asignatura',
                    'except' => ['delete','create','update']
                ],*/
                ['class' => 'yii\rest\UrlRule', 'controller' => 'user'],
            ],
        ],
    ],
    'params' => $params,
];
