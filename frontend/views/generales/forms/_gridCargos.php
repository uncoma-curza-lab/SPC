<?php

use yii\helpers\Html;
use yii\grid\GridView;
use common\models\Cargo;
use common\models\Persona;
use common\models\search\CargoSearch;
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
            'nombre_persona',


            [
              'class' => 'yii\grid\ActionColumn',
              'controller' => 'cargo'
            ],
        ],
    ]); ?>

</div>
