<?php

use yii\helpers\Html;
use \yii\helpers\HtmlPurifier;

use yii\grid\GridView;
use common\models\Unidad;
use common\models\search\UnidadSearch;
use yii\widgets\Pjax;
use yii\data\ActiveDataProvider;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\UnidadSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

?>

<div class="unidad-index">
  <p>
      <?= Html::a('Añadir una Unidad', ['unidad/create' , 'id' => $model->id], ['class' => 'btn btn-success']) ?>
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
                  return HtmlPurifier::process(substr($data->descripcion,0,200)."...");
                } else {
                  return $data->descripcion;
                }
              }
            ],
            [
              'attribute' => 'biblio_basica',
              'format' => 'html',
              'value' => function($data){
                if(strlen($data->biblio_basica) > 40){
                  return HtmlPurifier::process(substr($data->biblio_basica,0,200)."...");
                } else {
                  return $data->biblio_basica;
                }
              }
            ],
            [
              'attribute' => 'biblio_consulta',
              'format' => 'html',
              'value' => function($data){
                if(strlen($data->biblio_consulta) > 40){
                  return substr($data->biblio_consulta,0,200)."...";
                } else {
                  return $data->biblio_consulta;
                }
              }
            ],
            //'crono_tent',
            //'programa_id',

            [
              'class' => 'yii\grid\ActionColumn',
              'controller' => 'unidad'
            ],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
