<?php

use yii\helpers\Html;
use yii\grid\GridView;
use backend\models\Cargo;
use backend\models\Persona;
use backend\models\CargoSearch;
use yii\data\ActiveDataProvider;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\UnidadSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

?>

<div class="cargos-index">
  <p>
      <?= Html::submitButton('Insertar nuevo cargo',['class' => 'btn btn-success' , 'name'=>'submit','value' => 'cargo']) ?>
  </p>



    <?= GridView::widget([
        'dataProvider' => new ActiveDataProvider([
          'query' => $model->getCargos()
        ]),
        'filterModel' => new CargoSearch(),
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'designacion',
            [
              'attribute' => 'persona_id',
              'format' => 'text',
              'value' => function($model) {
                $persona= Persona::findOne($model->persona_id);
                return $persona->nombre." ".$persona->apellido;
              }
            ],

            [
              'class' => 'yii\grid\ActionColumn',
              'controller' => 'cargo'
            ],
        ],
    ]); ?>

</div>
