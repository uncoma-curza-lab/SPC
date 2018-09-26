<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use backend\models\Objetivo;
use yii\data\ActiveDataProvider;
use backend\models\ObjetivoSearch;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\ObjetivoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

?>
<div class="objetivo-index">

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Crear Objetivo', ['objetivo/create', 'id' => $model->id], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => new ActiveDataProvider([
          'query' => $model->getObjetivos()
        ]),
        'filterModel' => new ObjetivoSearch(),
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

            [
              'class' => 'yii\grid\ActionColumn',
              'controller' => 'objetivo'
            ],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
