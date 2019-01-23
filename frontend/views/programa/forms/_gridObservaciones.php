<?php

use yii\helpers\Html;
use yii\grid\GridView;
use common\models\search\ObservacionSearch;
use common\models\Status;
use yii\data\ActiveDataProvider;
use common\models\PermisosHelpers;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\search\ObservacionSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

//$this->params['breadcrumbs'][] = $this->title;
$estado_programa = Status::findOne(['=','id',$model->status_id]);

?>
<div class="observacion-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
      <?php if((PermisosHelpers::requerirDirector($model->id) && $estado_programa->descripcion == "Departamento")
                || ($estado_programa->descripcion == "Administración Académica"
                && PermisosHelpers::requerirRol('Adm_academica'))
                || ($estado_programa->descripcion == "Secretaría Académica"
                && PermisosHelpers::requerirRol('Sec_academica'))
              ): ?>
        <?= Html::a('Añadir Observacion', ['observacion/create','id' => $model->id], ['class' => 'btn btn-success']) ?>
      <?php endif; ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => new ActiveDataProvider([
          'query' => $model->getObservaciones()
        ]),
        'filterModel' => new ObservacionSearch(),
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
              'attribute' => 'texto',
              'format' => 'html',
              'value' => function($data){
                if(strlen($data->texto) > 40){
                  return substr($data->texto,0,200)."...";
                } else {
                  return $data->texto;
                }
              }
            ],
            [
              'class' => 'yii\grid\ActionColumn',
              'controller' => 'observacion',
              'template' => '{view} {update} {delete}',
              'buttons' => [
                'update' => function ($url,$model) {
                    if (PermisosHelpers::requerirMinimoRol('Admin')) {
                      return Html::a(
                        '<span style="padding:5px; font-size:20px;" class="glyphicon glyphicon-pencil"></span>',
                        $url);
                    } else {
                      return null;
                    }
                },
                'view' => function ($url,$model) {
                      return Html::a(
                        '<span style="padding:5px; font-size:20px;" class="glyphicon glyphicon-eye-open"></span>',
                        $url);
                },
                'delete' => function ($url,$model) {
                    if (PermisosHelpers::requerirMinimoRol('Admin')) {
                      return Html::a(
                        '<span style="padding:5px; font-size:20px;" class="glyphicon glyphicon-trash"></span>',
                        $url);
                    } else {
                      return null;
                    }
                },
              ]
            ],
        ],
    ]); ?>

</div>
