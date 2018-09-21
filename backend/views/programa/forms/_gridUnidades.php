<?php

use yii\helpers\Html;
use yii\grid\GridView;
use backend\models\Unidad;
use backend\models\UnidadSearch;
use yii\widgets\Pjax;
use yii\data\ActiveDataProvider;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\UnidadSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

?>
<div class="unidad-index">
  <p>
      <?= Html::a('Crear Unidad', ['unidad/create' , 'id' => $model->id], ['class' => 'btn btn-success']) ?>
  </p>
    <?php Pjax::begin(); ?>

    <?= GridView::widget([
        'dataProvider' => new ActiveDataProvider([
          'query' => $model->getUnidades()
        ]),
        'filterModel' => new UnidadSearch(),
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
              'attribute' => 'descripcion',
              'format' => 'html',
              'value' => function($data){
                if(strlen($data->descripcion) > 40){
                  return substr($data->descripcion,0,50)."...";
                } else {
                  return $data->descripcion;
                }
              }
            ],
            'biblio_basica',
            'biblio_consulta',
            'crono_tent',
            //'programa_id',

            [
              'class' => 'yii\grid\ActionColumn',
              'controller' => 'unidad'
            ],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
