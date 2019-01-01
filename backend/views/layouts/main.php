<?php

/* @var $this \yii\web\View */
/* @var $content string */
use yii\bootstrap\ButtonDropdown;

use backend\assets\AppAsset;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use common\widgets\Alert;
use common\models\PermisosHelpers;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?php
    NavBar::begin([
        'brandLabel' => Yii::$app->name,
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);
    $menuItems = [
        ['label' => 'Inicio', 'url' => ['/site/index']],
    ];
    if (Yii::$app->user->isGuest) {
        $menuItems[] = ['label' => 'Ingresar', 'url' => ['/site/login']];
    } else {
        if(PermisosHelpers::requerirMinimoRol('Usuario')){
          $menuItems[] = ['label' => 'Programas', 'url' => ['/programa/index']
            //$menuItems[] = ['label' => 'Informes', 'url' => ['/informes/index']];
          ];
        if(PermisosHelpers::requerirMinimoRol('Admin')){
          $menuItems[]=['label' => 'Controles', 'items' => [
          ['label' => 'Carreras', 'url' => ['/carrera/index']],
          ['label' => 'Departamento', 'url' => ['/departamento/index']],
          ['label' => 'Personas', 'url' => ['/persona/index']],
          ['label' => 'Roles', 'url' => ['/rol/index']],
          ['label' => 'Estados', 'url' => ['/status/index']],
          ['label' => 'Usuarios', 'url' => ['/user/index']],
          ['label' => 'Perfiles', 'url' => ['perfil/index']],
        ]];
        }
        $menuItems[] = ['label' => 'Salir (' . Yii::$app->user->identity->username . ')',
              'url' => ['/site/logout'],
              'linkOptions' => ['data-method' => 'post']
        ];
      }
    }
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => $menuItems,
    ]);
    NavBar::end();
    ?>


        <div class="container">
            <div class="row">
              <div class="col-xs-8">
                <?= Breadcrumbs::widget([
                    'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                ]) ?>
              </div>
              <div class="col-xs-4 text-right">
                <?php
                if(isset($this->params['items'] ))
                  echo ButtonDropdown::widget([
                    'label' => 'Ir a...',
                    'options' => [
                      'class' => "btn btn-primary "
                    ],
                    'dropdown' => [
                        'options' => ['class' => 'dropdown-menu-right', 'id' => 'buttons'],
                        'items' => isset($this->params['items']) ? $this->params['items'] : [],
                    ],
                  ]);
                ?>
              </div>
            </div>
            <?= Alert::widget() ?>

            <?= $content ?>
        </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; <?= Html::encode(Yii::$app->name) ?> <?= date('Y') ?></p>

        <p class="pull-right"><?= Yii::powered() ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
