<?php

/* @var $this \yii\web\View */
/* @var $content string */

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
          //$menuItems[] = ['label' => 'Programas', 'url' => ['/programa/index']
            //$menuItems[] = ['label' => 'Informes', 'url' => ['/informes/index']];
          //];
        if(PermisosHelpers::requerirMinimoRol('Admin')){
          $menuItems[]=[
            'label' => 'Controles', 'items' => [
              ['label' => 'Carreras', 'url' => ['/carrera/index']],
              ['label' => 'Departamentos', 'url' => ['/departamento/index']],
              ['label' => 'Planes', 'url' => ['/plan/index']],
              ['label' => 'Asignaturas', 'url' => ['/asignatura/index']],
              //['label' => 'Personas', 'url' => ['/persona/index']],
              ['label' => 'Estados', 'url' => ['/status/index']],
              ['label' => 'Modalidades', 'url' => ['/modalidad/index']],
              ['label' => 'Correlativas', 'url' => ['/correlativa/index']],
              ['label' => 'Relación CarreraModalidad', 'url' => ['/carrera-modalidad/index']],
              ['label' => 'Titulos Intermedios', 'url' => ['/titulo-intermedio/index']],
              ['label' => 'Niveles', 'url' => ['/nivel/index']],
              ['label' => 'Programas', 'url' => ['/programa/index']],
            ],
          ];
          $menuItems[] = [
            'label' => 'Sobre Usuarios', 'items' => [
              ['label' => 'Roles', 'url' => ['/rol/index']],
              ['label' => 'Usuarios', 'url' => ['/user/index']],
              ['label' => 'Perfiles', 'url' => ['perfil/index']],
              ['label' => 'Designaciones', 'url' => ['designacion/index']],
              ['label' => 'Acciones generales' , 'url' => ['/user/general']],
              ['label' => 'Estados' , 'url' => ['/estado']],
            ]
          ];
          $menuItems[] = [
            'label' => 'Notificaciones', 'items' => [
              ['label' => 'Event Type', 'url' => ['event-type/index']],
              ['label' => 'Control de notificaciones', 'url' => ['control-notification/index']],
            ]
          ];
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
                <?= Breadcrumbs::widget([
                    'homeLink' => [
                        'label' => Yii::t('yii', 'Inicio'),
                        'url' => Yii::$app->homeUrl,
                   ],
                    'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                ]) ?>

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
