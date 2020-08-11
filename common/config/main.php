<?php
return [
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
            // uncomment if you want to cache RBAC items hierarchy
            // 'cache' => 'cache',
        ],
        'elasticsearch' => [
            'class' => 'yii\elasticsearch\Connection',
            'autodetectCluster' => false,
            'nodes' => [
                [
                    'http_address' => 'elasticsearch:9200'
                ],
                // configure more hosts if you have a cluster
            ],
        ],
       
    ],
];
