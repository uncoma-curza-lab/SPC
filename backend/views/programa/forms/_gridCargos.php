<?php

use yii\helpers\Html;
use yii\grid\GridView;
use backend\models\Cargo;
use backend\models\CargoSearch;
use yii\data\ActiveDataProvider;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\UnidadSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

?>

<div class="unidad-index">
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

            'id',
            'designacion',
            'persona_id',
            'programa_id',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
