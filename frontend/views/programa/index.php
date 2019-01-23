<?php

use yii\helpers\Html;
use yii\grid\GridView;
use common\models\PermisosHelpers;
use common\models\RegistrosHelpers;
use common\models\Status;



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
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <?php if (PermisosHelpers::requerirRol('Departamento')) : ?>
    <p>
        <?= Html::a('Añadir Programa', ['anadir'], ['class' => 'btn btn-success']) ?>
    </p>
  <?php endif; ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
              'attribute' =>'departamento_id',
              'value' => function($model){
                $depto = $model->getDepartamento()->one();
                return isset($depto) ? $depto->nom : "NN";
              }
            ],
            [
              'attribute' => 'asignatura_id',
              'value' => function($model){
                $asignatura = $model->getAsignatura()->one();
                return isset($asignatura) ? $asignatura->nomenclatura : "NN";
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
                return Status::findOne($model->status_id)->descripcion;

              }
            ],
            [
                'label' => 'Creado Por',
                'visible' => $esAdmin,
                'value' => function($model){
                  return RegistrosHelpers::getUserName($model->created_by);
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
              'template' => $show_this_nav? '{asignar} {aprobar} {rechazar} {delete} {pdf} {ver} {cargar}':'{subir} {status} {pdf}',
              'buttons' => [
                /*'pdf' => function ($url,$model) {
                    return Html::a(
                        '<span style="padding:5px; font-size:20px;" class="glyphicon glyphicon-download"></span>',
                        ['export-pdf','id'=> $model->id],['target' => '_blank']);
                },*/
                'aprobar' => function ($url,$model){
                    if ((Status::findOne($model->status_id)->descripcion == "Borrador"
                        && PermisosHelpers::requerirDirector($model->id) && PermisosHelpers::existeProfAdjunto($model->id))
                        || (Status::findOne($model->status_id)->descripcion == "Departamento"
                          && PermisosHelpers::requerirRol('Departamento') && PermisosHelpers::requerirDirector($model->id))
                      || (Status::findOne($model->status_id)->descripcion == "Profesor"
                        && PermisosHelpers::requerirRol('Profesor') && PermisosHelpers::requerirProfesorAdjunto($model->id))
                      || (Status::findOne($model->status_id)->descripcion == "Administración Académica"
                        && PermisosHelpers::requerirRol('Adm_academica'))
                      || (Status::findOne($model->status_id)->descripcion == "Secretaría Académica"
                        && PermisosHelpers::requerirRol('Sec_academica'))
                      || PermisosHelpers::requerirMinimoRol('Admin'))
                    {
                        return Html::a(
                          '<span style="padding:5px; font-size:20px;" class="glyphicon glyphicon-ok"></span>',
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
                          '<span style="padding:5px; font-size:20px;" class="glyphicon glyphicon-remove"></span>',
                          ['rechazar','id' => $model->id],
                          [
                              'title' => Yii::t('yii', 'Rechazar'),
                          ]
                        );
                    }
                },
                'asignar' => function ($url,$model) {

                  if ((Status::findOne($model->status_id)->descripcion == "Borrador"
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
                  if ((Status::findOne($model->status_id)->descripcion == "Profesor"
                    && PermisosHelpers::requerirRol('Profesor'))
                    || PermisosHelpers::requerirMinimoRol('Admin'))
                  {
                    return Html::a(
                      '<span style="padding:5px; font-size:20px;" class="glyphicon glyphicon-pencil"></span>',
                      ['cargar','id' => $model->id]
                    );
                  }
                },
                'ver' => function ($url,$model) {
                    return Html::a(
                        '<span style="padding:5px; font-size:20px;" class="glyphicon glyphicon-info-sign"></span>',
                        //$url);
                        ['ver','id' => $model->id],
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
              ]
            ],
        ],
    ]); ?>
</div>
