<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\data\ActiveDataProvider;
use yii\widgets\Pjax;
use common\models\search\TemaSearch;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\TemaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
?>
<div class="tema-index">


    <?php Pjax::begin(); ?>
    <?= GridView::widget([
        'dataProvider' => new ActiveDataProvider([
          'query' => $model->getTemas()
        ]),
        'filterModel' => new TemaSearch(),
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
              'attribute' => 'descripcion',
              'format' => 'html',
              'value' => function($data){
                if(strlen($data->descripcion) > 40 ){
                    return  substr($data->descripcion,0,100)."...";
                } else {
                  return $data->descripcion;
                }
              },
            ],

            [
              'class' => 'yii\grid\ActionColumn',
              'controller' => 'tema'
            ],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
    <p>
        <?= Html::a('Crear tema', ['tema/create', 'id' => $model->id], ['class' => 'btn btn-success']) ?>
    </p>
</div>
