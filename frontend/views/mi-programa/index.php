<?php

use yii\helpers\Html;
use yii\grid\GridView;
use common\models\PermisosHelpers;
use common\models\RegistrosHelpers;
use common\models\Status;



/* @var $this yii\web\View */
/* @var $searchModel backend\models\ProgramaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */



$this->title = 'Mis programas';
$this->params['breadcrumbs'][] = $this->title;
$show_this_nav = PermisosHelpers::requerirMinimoRol('Profesor');
$esAdmin = PermisosHelpers::requerirMinimoRol('Admin');
?>
<div class="programa-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <p>
        <?= Html::a('Añadir Programa', ['anadir'],['id'=> 'agregar','class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'summary' => "Mostrando {begin} de {totalCount} programas",
        'emptyText' => 'No hay programas aún',
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
              'attribute' => 'asignatura_id',
              'value' => function($model){
                $string = $model->mostrarAsignatura();
                
                return $string;
              }
            ],
            'year',
            [
              'attribute' => 'completado',
              'value' => function($model){
                return $model->calcularPorcentajeCarga()."%";
              }
            ],
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
            [
              'label' => 'Estado',
              'attribute' => 'status',
              'value' => function($model) {
                $status = Status::findOne($model->status_id);
                return $status ?  $status->getDescripcion() :  "";

              }
            ],
            [
                'label' => 'Creado Por',
                'visible' => $esAdmin,
                'value' => function($model){
                  //return RegistrosHelpers::getNombreApellidoUser();
                  $creador = $model->getCreador();
                  return $creador ? $creador->printNombre() : "N/U";
                }
            ],
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
              'template' => $show_this_nav? ' {asignar} {aprobar} {rechazar} {delete} {pdf} {ver} {copy} {cargar}':'{subir} {status} {pdf}',
              'buttons' => [
                'pdf' => function ($url,$model) {
                    return Html::a(
                        '<span style="padding:5px; font-size:20px;color:gray" class="glyphicon glyphicon-print"></span>',
                        ['programa/export-pdf','id'=> $model->id],[
                            'title' => Yii::t('yii', 'Exportar PDF'),
                            'target' => '_blank'
                        ]);
                },
                'aprobar' => function ($url,$model){
                    $status = Status::findOne($model->status_id);
                    if ($status && (($status->descripcion == "Borrador"
                        && PermisosHelpers::requerirMinimoRol("Profesor")
                        && PermisosHelpers::requerirSerDueno($model->id))
                      || ($status->descripcion == "Departamento"
                          && PermisosHelpers::requerirRol('Departamento') && PermisosHelpers::requerirDirector($model->id))
                      || ($status->descripcion == "Administración Académica"
                        && PermisosHelpers::requerirRol('Adm_academica'))
                      || ($status->descripcion == "Secretaría Académica"
                        && PermisosHelpers::requerirRol('Sec_academica'))
                      || PermisosHelpers::requerirMinimoRol('Admin')))
                    {
                        return Html::a(
                          '<span style="padding:5px; font-size:20px;color:#5cb85c" class="glyphicon glyphicon-send"></span>',
                          ['programa/aprobar','id' => $model->id],
                          [
                              'title' => Yii::t('yii', 'Enviar a evaluación'),
                              'data' => [
                                'method' => 'post',
                                'confirm' => Yii::t('yii', '¿Quiere confirmar el programa? Una vez que lo confirme deberá esperar la evaluación del mismo'),
                              ],
                          ]
                        );
                    }
                },
                'rechazar' => function ($url,$model){
                    $status = Status::findOne($model->status_id);
                    if ($status && (($status->descripcion == "Profesor"
                        && PermisosHelpers::requerirRol('Profesor')
                        && PermisosHelpers::requerirProfesorAdjunto($model->id))
                      || ($status->descripcion == "Departamento"
                        && PermisosHelpers::requerirRol('Departamento') && PermisosHelpers::requerirDirector($model->id))
                      || ($status->descripcion == "Administración Académica"
                        && PermisosHelpers::requerirRol('Adm_academica'))
                      || ($status->descripcion == "Secretaría Académica"
                        && PermisosHelpers::requerirRol('Sec_academica'))
                      || PermisosHelpers::requerirMinimoRol('Admin')))
                    {
                        return Html::a(
                          '<span style="padding:5px; font-size:20px;color:#d9534f" class="glyphicon glyphicon-remove"></span>',
                          ['programa/rechazar','id' => $model->id],
                          [
                              'title' => Yii::t('yii', 'Rechazar'),
                              'data-confirm' => Yii::t('yii', 'Está a punto de rechazar el programa. Recuerde añadir observaciones'),
                              'data-method' => 'post',
                          ]
                        );
                    }
                },
                'asignar' => function ($url,$model) {
                  $status = Status::findOne($model->status_id);
                  
                  if ( $status && ($status->descripcion == "Borrador"
                      //&& PermisosHelpers::requerirRol('Departamento')
                      //&& PermisosHelpers::requerirDirector($model->id)
                      && PermisosHelpers::requerirSerDueno($model->id))
                    || PermisosHelpers::requerirMinimoRol('Admin'))
                  {
                    return Html::a(
                      '<span style="padding:5px; font-size:20px;" class="glyphicon glyphicon-user"></span>',
                      ['asignar','id' => $model->id],
                      [
                          'title' => Yii::t('yii', 'Modificar equipo de cátedra'),
                      ]
                    );
                  }
                },
                'cargar' => function ($url,$model) {
                  $status = Status::findOne($model->status_id);
                  if (
                      $status &&
                      $status->descripcion == "Borrador" &&
                      PermisosHelpers::requerirMinimoRol('Profesor') &&
                      PermisosHelpers::requerirSerDueno($model->id)
                  )
                  {
                    return Html::a(
                      '<span style="padding:5px; font-size:20px; color:orange" class="glyphicon glyphicon-pencil "></span>',
                      ['dist-horaria','id' => $model->id]
                    );
                  }
                },
                // por ahora no deberia existir mas 
                // el director ni el depto puede editar el programa
                //'editar' => function ($url,$model) {
                //  $status = Status::findOne($model->status_id);
                //  if ($status && ($status->descripcion == "Borrador"
                //      && PermisosHelpers::requerirDirector($model->id) && PermisosHelpers::existeProfAdjunto($model->id))
                //      || ($status->descripcion == "Departamento"
                //        && PermisosHelpers::requerirRol('Departamento') && PermisosHelpers::requerirDirector($model->id)))
                //  {
                //    return Html::a(
                //      '<span style="padding:5px; font-size:20px;" class="glyphicon glyphicon-pencil"></span>',
                //      ['editar','id' => $model->id]
                //    );
                //  }
                //},
                
                'ver' => function ($url,$model) {
                    return Html::a(
                        '<span style="padding:5px; font-size:20px; color:	#0CB7F2" class="glyphicon glyphicon-comment"></span>',
                        //$url);
                        ['programa/ver','id' => $model->id],
                        [
                            'title' => Yii::t('yii', 'Observaciones'),
                        ]);
                },
                'copy' => function ($url,$model) {
                  return Html::a(
                      '<span style="padding:5px; font-size:20px; color:	#BFAB57" class="glyphicon glyphicon-duplicate"></span>',
                      //$url);
                      ['programa/copy','id' => $model->id],
                      [
                          'title' => Yii::t('yii', 'Copiar'),
                      ]);
                },
                'view' => function ($url,$model) {
                    return Html::a(
                        '<span style="padding:5px; font-size:20px;" class="glyphicon glyphicon-eye-open"></span>',
                        $url,
                        [
                            'title' => Yii::t('yii', 'Ver'),
                        ]
                      );
                },

                'delete' => function ($url,$model) {
                    $userid  = Yii::$app->user->identity->id;
                    $status = Status::findOne($model->status_id);
                    if ($status && ($status->descripcion == "Borrador"
                          && PermisosHelpers::requerirSerDueno($model->id))
                        || PermisosHelpers::requerirMinimoRol('Admin'))
                    {
                      return Html::a(
                        '<span style="padding:5px; font-size:20px; color:	#d9534f" class="glyphicon glyphicon-trash"></span>',
                        ['programa/delete', 'id' => $model->id],
                        [
                            'title' => Yii::t('yii', 'Eliminar'),
                            'data-confirm' => Yii::t('yii', '¿Quiere eliminar el programa?'),
                            'data-method' => 'post',
                        ]
                      );
                    }
                },
                'time-distribution' => function($url, $model) {
                    return Html::a(
                      '<span style="padding:5px; font-size:20px; color:	#807979" class="glyphicon glyphicon-dashboard"></span>',
                      ['time-distribution/view', 'id' => $model->id],
                      [
                          'title' => Yii::t('yii', 'Ver distribución horaria'),
                      ]
                    );
                }
              ]
            ],
        ],
    ]); ?>
</div>

<div class="row">
  <div class="col-lg-8 col-lg-offset-3">
    <span class="label label-primary "><span class="glyphicon glyphicon-user"></span>Equipo de cátedra</span>
    <span class="label label-success "><span class="glyphicon glyphicon-send"></span> Enviar</span>
    <span class="label label-info"><span class="glyphicon glyphicon-comment"></span> Observaciones</span>
    <span class="label label-danger "><span class="glyphicon glyphicon-trash"></span> Eliminar</span>
    <span class="label label-default"><span class="glyphicon glyphicon-print"></span> Exportar PDF</span>
    <span class="label label-warning"><span class="glyphicon glyphicon-pencil"></span> Editar</span>
    <span class="label" style="background-color: #BFAB57"><span class="glyphicon glyphicon-glyphicon glyphicon-duplicate"></span> Copiar </span>
    
  </div>
</div>
