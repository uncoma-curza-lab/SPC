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
                        'v1/asignatura'=> 'v1/asignatura'
                    ],
                    'pluralize' => false,
                    'tokens' => [
                        '{id}' => '<id:\\w+>'
                    ],
                    'extraPatterns' => [
                        //'GET asigns/<id>' => 'asignatura/buscar',
                        'GET plan' => 'asignaturas'
                    ],
                    'except' => ['delete','create','update']
                ],
                [
                    'class' => 'yii\rest\UrlRule', 
                    'controller' => [
                        'v1/departamento'=> 'v1/departamento',
                    ],
                    'extraPatterns' => [
                        //'GET /' => 'index',
                        'GET carrera' => 'carrera'
                    ]
                ],
                [
                    'class' => 'yii\rest\UrlRule', 
                    'controller' => [
                        'v1/carrera'=> 'v1/carrera',
                    ],
                
                    'extraPatterns' => [
                        'GET departamento' => 'dptos'
                    ],
                ],
                [
                    'class' => 'yii\rest\UrlRule', 
                    'controller' => [
                        'v1/plan'=> 'v1/plan'
                    ],
                    'extraPatterns' => [
                        'GET carrera' => 'carreras'
                    ],
                    //'tokens' => [
                    //    '{dpto}' => '<dpto:\\w+>'
                    //],
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => [
                        'v1/biblioteca' => 'v1/biblioteca'
                    ],
                    'patterns' => [
                        'GET' => 'index',
                        'GET,HEAD {id}' => 'get-id',
                    ],

                    'extraPatterns' => [
                        'GET export/<id:\d+>' => 'export-pdf',

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
        'urlManagerBackend' => [
            'enablePrettyUrl' => true,
            'class' => 'yii\web\UrlManager',
            'showScriptName' => false,
            'suffix' => '.html',
            'hostInfo' => 'http://'.$_SERVER['HTTP_HOST'].'/backend',
            'baseUrl' => 'http://'.$_SERVER['HTTP_HOST'].'/backend'

        ]
    ],
    'params' => $params,
];
