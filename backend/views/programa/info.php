<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use common\models\PermisosHelpers;
use common\models\EstadoHelpers;

use yii\widgets\DetailView;
use yii\bootstrap\card;
use backend\models\CarreraProgramaSearch;
use backend\models\Status;

use backend\models\CarreraPrograma;
use backend\models\Carrera;
use yii\data\ActiveDataProvider;
use kartik\tabs\TabsX;

$show_this_nav = PermisosHelpers::requerirMinimoRol('Profesor');
$esAdmin = PermisosHelpers::requerirMinimoRol('Admin');
$estado_programa = Status::findOne(['=','id',$model->status_id]);
$mostrar = isset($estado_programa) && ($estado_programa->value > EstadoHelpers::getValue('Borrador'));
$items = [
    [
      'label' => 'Programa',
      'content' => $this->render('pdf',['model' => $model]),
      'active'=>true,
    ],
    [
        'label'=>'<i class="fas fa-home"></i> Observaciones',
        'content'=>// if (PermisosHelpers::requerirMinimoRol('Departamento'))
                  $this->render('forms/_gridObservaciones',['model' => $model]),
        'visible' => $mostrar,
    ],
    [
        'label'=>'<i class="fas fa-user"></i> Carreras',
        'visible' => $mostrar,
        'content'=> GridView::widget([
          'dataProvider' => new ActiveDataProvider([
            'query' => $model->getCarrerap()
          ]),
          'filterModel' => new CarreraProgramaSearch(),
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                [
                  'attribute' => 'carrera_id',
                  'format' => 'text',
                  'value' => function($model){
                    return Carrera::findOne($model->carrera_id)->nom;
                  }
                ],
                [
                  'attribute' => 'estado',
                  'value' => function($model){
                    if (!isset($model->estado))
                      return "Sin evaluar";
                    else if ($model->estado == 1){
                      return "Aprobado";
                    }  else
                      return "Desaprobado";
                  }
                ],
                [
                  'class' => 'yii\grid\ActionColumn',
                  'controller' => 'carrera-programa',
                  //'template' => $show_this_nav? '{view} {update} {delete} {pdf} {status}':'{view} {status} {pdf}',
                  'template' => '{aprobar} {desaprobar}',
                  'buttons' => [
                    'aprobar' => function ($url,$model) {
                      $perfil_user  = Yii::$app->user->identity->perfil;
                      $carrera = Carrera::findOne(['id','=',$model->carrera_id]);
                      if((PermisosHelpers::requerirMinimoRol('Departamento') && isset($perfil_user->departamento_id ) && $perfil_user->departamento_id == $carrera->departamento_id) ||  PermisosHelpers::requerirMinimoRol('Admin')){
                        return Html::a(
                            '<span style="padding:5px; font-size:20px;" class="glyphicon glyphicon-ok"></span>',
                            ['carrera-programa/aprobar','id' => $model->id],
                            [
                                'title' => Yii::t('yii', 'Aprobar'),
                                'data-confirm' => Yii::t('yii', '¿Quiere aprobar el programa para esta carrera?'),
                                'data-method' => 'post',
                            ]);
                        }
                    },
                    'desaprobar' => function ($url,$model) {
                      $perfil_user  = Yii::$app->user->identity->perfil;
                      $carrera = Carrera::findOne(['id','=',$model->carrera_id]);
                      if((PermisosHelpers::requerirMinimoRol('Departamento') && isset($perfil_user->departamento_id ) && $perfil_user->departamento_id == $carrera->departamento_id ) || PermisosHelpers::requerirMinimoRol('Admin') ){
                        return Html::a(
                            '<span style="padding:5px; font-size:20px;" class="glyphicon glyphicon-remove"></span>',
                            ['carrera-programa/desaprobar','id' => $model->id],
                            [
                                'title' => Yii::t('yii', 'Desaprobar'),
                                'data-confirm' => Yii::t('yii', '¿Quiere desaprobar el programa para esta carrera? Recuerde añadir antes una observación'),
                                'data-method' => 'post',
                            ]);
                      }
                    },
                  ],

                ],
            ],
        ]) ,
    ],


];


?>

<?=  TabsX::widget([
    'items'=>$items,
    'position'=>TabsX::POS_ABOVE,
    //'align'=>TabsX::ALIGN_CENTER,
    'height' => TabsX::SIZE_MEDIUM,
    'bordered'=>true,
    'encodeLabels'=>false,

    'enableStickyTabs' => true,
    'stickyTabsOptions' => [
        'selectorAttribute' => 'data-target',
        'backToTop' => true,

    ],
]); ?>


  <div class="col-xs-6">
    <!-- <?php if ( PermisosHelpers::requerirMinimoRol('Departamento') ) : ?>
      <h3>Observaciones</h3>
        <?= $this->render('forms/_gridObservaciones',['model' => $model]) ?>
    <?php endif; ?> -->
  </div>
