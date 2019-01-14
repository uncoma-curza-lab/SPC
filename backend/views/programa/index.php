<?php

use yii\helpers\Html;
use yii\grid\GridView;
use common\models\PermisosHelpers;
use common\models\RegistrosHelpers;
use backend\models\Status;



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

    <p>
        <?= Html::a('Añadir Programa', ['anadir'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'departamento_id',
            'status_id',
            'asignatura_id',
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
              'template' => $show_this_nav? '{subir} {delete} {pdf} {ver} {cargar}':'{subir} {status} {pdf}',
              'buttons' => [
                'pdf' => function ($url,$model) {
                    return Html::a(
                        '<span style="padding:5px; font-size:20px;" class="glyphicon glyphicon-download"></span>',
                        ['export-pdf','id'=> $model->id],['target' => '_blank']);
                },
                'subir' => function ($url,$model){
                    if ((Status::findOne($model->status_id)->descripcion == "Profesor"
                      && PermisosHelpers::requerirRol('Profesor') && PermisosHelpers::requerirProfesorAdjunto($model->id))
                      || (Status::findOne($model->status_id)->descripcion == "Departamento"
                        && PermisosHelpers::requerirRol('Departamento') && PermisosHelpers::requerirDirector($model->id))
                      || PermisosHelpers::requerirMinimoRol('Admin'))
                    {
                        return Html::a(
                          '<span style="padding:5px; font-size:20px;" class="glyphicon glyphicon-upload"></span>',
                          ['subir-estado','id' => $model->id]
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
                        ['ver','id' => $model->id]);
                },
                'view' => function ($url,$model) {
                    return Html::a(
                        '<span style="padding:5px; font-size:20px;" class="glyphicon glyphicon-eye-open"></span>',
                        $url);
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
