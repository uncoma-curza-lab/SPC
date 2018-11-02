
<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use common\models\PermisosHelpers;
use backend\models\Status;
use common\models\RegistrosHelpers;
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
    <div class="container">
      <?php
      if (!Yii::$app->user->isGuest && $show_this_nav){
          //echo Html::a(Yii::t('app', 'Agregar Adjunto'), ['create'], ['class' => 'btn btn-success']);
          echo Html::a('Crear Programa', ['create'], ['class' => 'btn btn-success']);
      };
      ?>
    </div>
    <br>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'asignatura',
            'curso',
            'year',
            [
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
            ],
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
            //'profadj_regular',
            //'asist_regular',
            //'ayudante_p',
            //'ayudante_s',
            //'fundament',
            //'objetivo_plan',
            //'contenido_plan',
            //'propuesta_met',
            //'evycond_acreditacion',
            //'parcial_rec_promo',
            //'distr_horaria',
            //'actv_extracur',
            //'created_at',
            //'updated_at',
            //'created_by',
            //'updated_by',

            [
              'class' => 'yii\grid\ActionColumn',
              'template' => $show_this_nav? '{view} {update} {delete} {pdf} {status}':'{view} {status} {pdf}',

              'buttons' => [
                'pdf' => function ($url,$model) {
                    return Html::a(
                        '<span style="padding:5px; font-size:20px;" class="glyphicon glyphicon-download"></span>',
                        ['export-pdf','id'=> $model->id],['target' => '_blank']);
                },
                'status' => function ($url,$model) {
                    return Html::a(
                        '<span style="padding:5px; font-size:20px;" class="glyphicon glyphicon-info-sign"></span>',
                        $url);
                },
                'view' => function ($url,$model) {
                    return Html::a(
                        '<span style="padding:5px; font-size:20px;" class="glyphicon glyphicon-eye-open"></span>',
                        $url);
                },
                'update' => function ($url,$model) {
                    return Html::a(
                        '<span style="padding:5px; font-size:20px;" class="glyphicon glyphicon-pencil"></span>',
                        $url);
                },
                'delete' => function ($url,$model) {
                    return Html::a(
                        '<span style="padding:5px; font-size:20px;" class="glyphicon glyphicon-trash"></span>',
                        $url,
                        [
                            'title' => Yii::t('yii', 'Delete'),
                            'data-confirm' => Yii::t('yii', 'Quiere eliminar el programa?'),
                            'data-method' => 'post',
                        ]
                    );
                },
              ]
            ],
        ],
    ]); ?>
</div>
