<?php

use yii\helpers\Html;
use yii\grid\GridView;
use common\models\Status;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\search\RolSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Adminsitrador de Programas';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="administrador-programas-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            [
                'attribute' => 'asignatura',
                'value' => function($model){
                  $asignatura = $model->getAsignatura()->one();
                  return isset($asignatura) ? $asignatura->nomenclatura : "No tiene";
                }
              ],
              'year',
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
              [
                'attribute' => 'departamento',
                'value' => function($model){
                  //$dpto = $model->getAsignatura()->one()->getDepartamento()->one();
                  $dpto = $model->getDepartamento()->one();
                  return $dpto ? $dpto->nom : "Sin asignar";
                }
              ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
