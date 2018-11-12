<?php

use yii\helpers\Html;
use yii\grid\GridView;
use backend\models\ObservacionSearch;
use yii\data\ActiveDataProvider;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\search\ObservacionSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->params['breadcrumbs'][] = $this->title;
?>
<div class="observacion-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
      <?= Html::submitButton('Añadir una observación',['class' => 'btn btn-warning' , 'name'=>'submit','value' => 'observacion']) ?>

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
              'controller' => 'observacion'
            ],
        ],
    ]); ?>
</div>
