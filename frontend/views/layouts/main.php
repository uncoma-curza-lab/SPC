<?php

/* @var $this \yii\web\View */
/* @var $content string */
use  yii\web\View;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use common\widgets\Alert;
use yii\bootstrap\ButtonDropdown;
use common\models\PermisosHelpers;
use common\models\NotificationPanel;
AppAsset::register($this);
if( !Yii::$app->user->isGuest){
  $perfil = Yii::$app->user->identity->perfil;
  $nombre="";
  if($perfil){
      $nombre=Yii::$app->user->identity->perfil->printNombre();
  }
  $countNotif = NotificationPanel::find()->filterWhere(['=','user_receiver',Yii::$app->user->identity->id])->andFilterWhere(['=','read',null])->count();
}
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
        [
          'label' => 'Inicio', 'url' => ['/site/index'],
        ],
     
      //  ['label' => 'About', 'url' => ['/site/about']],
      //  ['label' => 'Contact', 'url' => ['/site/contact']],
    ];

    if (Yii::$app->user->isGuest) {
        //$menuItems[] = ['label' => 'Signup', 'url' => ['/site/signup']];
        $menuItems[] = ['label' => 'Acceder', 'url' => ['/site/login']];
    } else {
        $menuItems[] = [
          'label' => 'Notificaciones '. Html::tag('span',$countNotif,['class' => 'badge']),
          'linksOptions' => ['class'=>'<a href="#">Inbox <span class="badge">42</span></a>'],
          'url' => ['/user-notifications/index'],
        ];
        $menuItems[] = [
          
          'label' => "Programas",
          'options'=> ['id'=>'programaLink'],

          'items' =>[
            [
              'label' => 'Mis Programas',
              'url' => ['/mi-programa/index'],
            ],
            [
              'label' => 'Todos',
              'url' => ['/generales/index'],
            ],
            [
              'label' => 'En evaluación',
              'url' => ['/programa/evaluacion'],
              'visible' => PermisosHelpers::requerirRol("Departamento") ||
                           PermisosHelpers::requerirRol("Sec_academica") ||
                           PermisosHelpers::requerirRol("Adm_academica") ||
                           PermisosHelpers::requerirRol("SuperUsuario")
            ]

          ]
        ];
       
        $menuItems[] = [
          'label' => '¡Hola '. $nombre .'!',
          'items' =>[
            ['label' => 'Perfil', 'url' => ['/perfil/view']],
            ['label' => 'Gestión de clave', 'url' => ['/site/change-password']],
            [
               'label' => 'Salir (' . Yii::$app->user->identity->username . ')',
               'url' => ['/site/logout'],
               'linkOptions' => ['data-method' => 'post']
            ],
            ]
        ];
        /*$menuItems[] = '<li>'
            . Html::beginForm(['/site/logout'], 'post')
            . Html::submitButton(
                'Salir (' . Yii::$app->user->identity->username . ')',
                ['class' => 'btn btn-link logout']
            )
            . Html::endForm()
            . '</li>';
        */
    }
    $menuItems[] =[
      'label' => 'Ayuda', 'url' => ['/site/ayuda'],
    ];
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => $menuItems,
        'encodeLabels' => false,
    ]);
    NavBar::end();
    ?>

    <div class="container">
      <div class="row">
        <div class="col-xs-8">
          <?= Breadcrumbs::widget([
              'homeLink' => [
                  'label' => Yii::t('yii', 'Inicio'),
                  'url' => Yii::$app->homeUrl,
             ],
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
        <!--<p class="pull-left">&copy; <?= Html::encode(Yii::$app->name) ?> <?= date('Y') ?></p>-->
        <p class="pull-left"> <?= Html::encode(Yii::$app->name) ?> <?= date('Y') ?>
        <p class="pull-right">Desarrollado por: <i>Departamento de Ciencia y Tecnología</i><? Yii::powered() ?></p>
    </div>
</footer>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
