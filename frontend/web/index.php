<?php
defined('YII_DEBUG') or define('YII_DEBUG', $_ENV['YII_DEBUG'] == 'true');
defined('YII_ENV') or define('YII_ENV', $_ENV['YII_ENV']);
defined('SPC_URL_API') or define('SPC_URL_API', $_ENV['SPC_URL_API']);

require __DIR__ . '/../../vendor/autoload.php';
require __DIR__ . '/../../vendor/yiisoft/yii2/Yii.php';
require __DIR__ . '/../../common/config/bootstrap.php';
require __DIR__ . '/../config/bootstrap.php';

$config = yii\helpers\ArrayHelper::merge(
    require __DIR__ . '/../../common/config/main.php',
    require __DIR__ . '/../../common/config/main-local.php',
    require __DIR__ . '/../config/main.php',
    require __DIR__ . '/../config/main-local.php'
);

(new yii\web\Application($config))->run();
