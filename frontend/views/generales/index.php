<?php

use yii\helpers\Html;
use yii\grid\GridView;
use common\models\PermisosHelpers;
use common\models\RegistrosHelpers;
use common\models\Status;
use \yii\bootstrap\Collapse;
use common\models\User;



/* @var $this yii\web\View */
/* @var $searchModel backend\models\ProgramaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */



$this->title = 'Programas';
$this->params['breadcrumbs'][] = $this->title;
$show_this_nav = PermisosHelpers::requerirMinimoRol('Profesor');
$esAdmin = PermisosHelpers::requerirMinimoRol('Admin');
?>

<div class="programa-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?=    Collapse::widget([

             'items' => [
             // equivalent to the above
             [
             'label' => 'Haga click aquí para buscar',
             'content' => $this->render('_search', ['model' => $searchModel]) ,
             'options' => ['class' => 'panel panel-info'],
             // open its content by default
             //'contentOptions' => ['class' => 'in']
              ],

              ]
              ]); ?>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'summary' => "Mostrando {begin} de {totalCount} programas",
        'emptyText' => 'No hay programas aún',
        'filterModel' => $searchModel,
          'options'=>[
            'style' => ' table-layout: fixed; '
          ],
          'tableOptions'=>['class'=>'table-striped table-bordered table-condensed'],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
              'attribute' => 'asignatura',
              'value' => function($model){
                $asignatura = $model->getAsignatura()->one();
                return isset($asignatura) ? $asignatura->nomenclatura : "No tiene";
              }
            ],
            'year',

          /*  [
              'attribute' => 'cuatrimestre',
              'format' => 'text',
              'value' => function($model){
                if ($model->cuatrimestre == 1 ){
                  return "Primer cuatrimestre";
                } else if ($model->cuatrimestre == 2) {
                  return "Segundo cuatrimestre";
                } else {
                  return "#ERROR: No existe cuatrimestre (Programa)";
                }
              }
            ],*/
            /*[
              'attribute' => 'departamento',
              'value' => function($model){
                //$dpto = $model->getAsignatura()->one()->getDepartamento()->one();
                $dpto = $model->getDepartamento()->one();
                return $dpto ? $dpto->nom : "Sin asignar";
              }
            ],*/
            [
              'label' => 'Estado',
              'attribute' => 'status',
              'value' => function($model) {
                return Status::findOne($model->status_id)->getDescripcion();

              }
            ],
            [
                'label' => 'Creado Por',
                'attribute' => 'perfil',
                'contentOptions' => ['style' => 'width:2%;  max-width:1%;  white-space:nowrap; overflow: hidden; text-overflow: ellipsis;'],
                //'visible' => $esAdmin,
                'value' => function($model){
                  $perfil = $model->getCreador();
                  return $perfil ? $perfil->printNombre() : "N/N";
                  //return RegistrosHelpers::getUserName($model->created_by);
                }
            ],
            [
              'attribute' => 'completado',
              'headerOptions' => ['style' => 'width:20px'],
              'contentOptions' => ['style' => 'width:2px;  max-width:2px;  '],

              'value' => function($model){
                return $model->calcularPorcentajeCarga()."%";
              }
            ],
            //'year',
            //'cuatrimestre',
            //'fundament:ntext',
            //'objetivo_plan:ntext',
            //'contenido_plan:ntext',
            //'propuesta_met:ntext',
            //'evycond_acreditacion:ntext',
            //'parcial_rec_promo:ntext',
            //'distr_horaria:ntext',
            //'crono_tentativo:ntext',
            //'actv_extracur:ntext',
            //'created_at',
            //'updated_at',
            //'created_by',
            //'updated_by',

            [
              'class' => 'yii\grid\ActionColumn',
              //'template' => $show_this_nav? '{view} {update} {delete} {pdf} {status}':'{view} {status} {pdf}',
              'template' => $show_this_nav? '{pedir} {pdf} {ver}':' {pdf}',
              'buttons' => [
                'pdf' => function ($url,$model) {
                    return Html::a(
                        '<span style="padding:5px; font-size:20px;color:gray" class="glyphicon glyphicon-print"></span>',
                        ['export-pdf','id'=> $model->id],['title' => Yii::t('yii', 'Exportar PDF'),'target' => '_blank']);
                },
                'aprobar' => function ($url,$model){
                    if ((Status::findOne($model->status_id)->descripcion == "Borrador"
                        //&& PermisosHelpers::requerirDirector($model->id)
                        //&& PermisosHelpers::existeProfAdjunto($model->id))
                          && PermisosHelpers::requerirMinimoRol("Profesor")
                          && PermisosHelpers::requerirSerDueno($model->id))
                      || (Status::findOne($model->status_id)->descripcion == "Departamento"
                          && PermisosHelpers::requerirRol('Departamento') //no hace falta
                          && PermisosHelpers::requerirDirector($model->id))
                      || (Status::findOne($model->status_id)->descripcion == "Administración Académica"
                          && PermisosHelpers::requerirRol('Adm_academica'))
                      || (Status::findOne($model->status_id)->descripcion == "Secretaría Académica"
                          && PermisosHelpers::requerirRol('Sec_academica'))
                      || PermisosHelpers::requerirMinimoRol('Admin'))
                    {
                        return Html::a(
                          '<span style="padding:5px; font-size:20px;color:#5cb85c" class="glyphicon glyphicon-ok"></span>',
                          ['aprobar','id' => $model->id],
                          [
                              'title' => Yii::t('yii', 'Aprobar'),
                          ]
                        );
                    }
                },
                'rechazar' => function ($url,$model){
                    if ((Status::findOne($model->status_id)->descripcion == "Profesor"
                      && PermisosHelpers::requerirRol('Profesor') && PermisosHelpers::requerirProfesorAdjunto($model->id))
                      || (Status::findOne($model->status_id)->descripcion == "Departamento"
                        && PermisosHelpers::requerirRol('Departamento') && PermisosHelpers::requerirDirector($model->id))
                      || (Status::findOne($model->status_id)->descripcion == "Administración Académica"
                        && PermisosHelpers::requerirRol('Adm_academica'))
                      || (Status::findOne($model->status_id)->descripcion == "Secretaría Académica"
                        && PermisosHelpers::requerirRol('Sec_academica'))
                      || PermisosHelpers::requerirMinimoRol('Admin'))
                    {
                        return Html::a(
                          '<span style="padding:5px; font-size:20px;color:#d9534f" class="glyphicon glyphicon-remove"></span>',
                          ['rechazar','id' => $model->id],
                          [
                              'title' => Yii::t('yii', 'Rechazar'),
                          ]
                        );
                    }
                },
                'asignar' => function ($url,$model) {

                  if ((Status::findOne($model->status_id)->descripcion == "Departamento"
                     && PermisosHelpers::requerirRol('Departamento')
                     && PermisosHelpers::requerirDirector($model->id))
                    || PermisosHelpers::requerirMinimoRol('Admin'))
                  {
                    return Html::a(
                      '<span style="padding:5px; font-size:20px;" class="glyphicon glyphicon-user"></span>',
                      ['designacion/asignar','id' => $model->id],
                      [
                          'title' => Yii::t('yii', 'Asignar cargo'),
                      ]
                    );
                  }
                },
                'cargar' => function ($url,$model) {
                  if (Status::findOne($model->status_id)->descripcion == "Borrador"
                    && PermisosHelpers::requerirMinimoRol('Profesor')
                    && PermisosHelpers::requerirSerDueno($model->id))
                  {
                    return Html::a(
                      '<span style="padding:5px; font-size:20px;" class="glyphicon glyphicon-pencil"></span>',
                      ['mi-programa/cargar','id' => $model->id]
                    );
                  }
                },
                'editar' => function ($url,$model) {
                  if ( (Status::findOne($model->status_id)->descripcion == "Departamento"
                        && PermisosHelpers::requerirRol('Departamento')
                        && PermisosHelpers::requerirDirector($model->id)))
                  {
                    return Html::a(
                      '<span style="padding:5px; font-size:20px;" class="glyphicon glyphicon-pencil"></span>',
                      ['editar','id' => $model->id]
                    );
                  }
                },
                'ver' => function ($url,$model) {
                    return Html::a(
                        '<span style="padding:5px; font-size:20px;color:	#0CB7F2" class="glyphicon glyphicon-info-sign"></span>',
                        //$url);
                        ['programa/ver','id' => $model->id],
                        [
                            'title' => Yii::t('yii', 'Información'),
                        ]);
                },
                'view' => function ($url,$model) {
                    return Html::a(
                        '<span style="padding:5px; font-size:20px;" class="glyphicon glyphicon-eye-open"></span>',
                        $url,
                        [
                            'title' => Yii::t('yii', 'Eliminar'),
                        ]
                      );
                },

                'delete' => function ($url,$model) {
                    $userid  = Yii::$app->user->identity->id;
                    if ((Status::findOne($model->status_id)->descripcion == "Borrador" && $model->created_by == $userid) || PermisosHelpers::requerirMinimoRol('Admin'))
                    {
                      return Html::a(
                        '<span style="padding:5px; font-size:20px;" class="glyphicon glyphicon-trash"></span>',
                        $url,
                        [
                            'title' => Yii::t('yii', 'Eliminar'),
                            'data-confirm' => Yii::t('yii', '¿Quiere eliminar el programa?'),
                            'data-method' => 'post',
                        ]
                      );
                    }

                },
                'pedir' => function ($url,$model) {

                  if (($model->getStatus()->one()->descripcion == "En espera"
                     && PermisosHelpers::requerirRol('Departamento')
                    // && PermisosHelpers::requerirDirector($model->id)
                    && !isset($model->departamento_id))
                    || PermisosHelpers::requerirMinimoRol('Admin'))
                  {
                    return Html::a(
                      '<span style="padding:5px; font-size:20px;" class="glyphicon glyphicon-hand-up"></span>',
                      ['pedir','id' => $model->id],
                      [
                          'title' => Yii::t('yii', 'Asignarme el programa'),
                      ]
                    );
                  }
                },
              ]
            ],
        ],
    ]);
    ?>

</div>
<hr>
<div class="row">
  <div class="col-lg-6 col-lg-offset-4">
    <span class="label label-primary "><span class="glyphicon glyphicon-hand-up"></span> Asignarme el programa</span>
    <span class="label label-info"><span class="glyphicon glyphicon-info-sign"></span> Más información</span>
    <span class="label label-default"><span class="glyphicon glyphicon-print"></span> Exportar PDF</span>
  </div>
</div>
