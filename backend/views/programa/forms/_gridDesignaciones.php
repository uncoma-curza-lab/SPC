<?php

use yii\helpers\Html;
use yii\grid\GridView;
use backend\models\Designacion;
use backend\models\Cargo;
use backend\models\Status;
use backend\models\Persona;
use common\models\PermisosHelpers;
use backend\models\DesignacionSearch;
use yii\data\ActiveDataProvider;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\UnidadSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$show_this_nav = (Status::findOne($model->status_id)->descripcion == "Borrador") &&
                  (PermisosHelpers::requerirDirector($model->id));
?>

<div class="cargos-index">
  <?php if($show_this_nav): ?>
  <p>
      <?= Html::submitButton('Insertar nueva desingacion',['class' => 'btn btn-success' , 'name'=>'submit','value' => 'cargo']) ?>
  </p>
  <?php endif; ?>



    <?= GridView::widget([
        'dataProvider' => new ActiveDataProvider([
          'query' => $model->getDesignaciones()
        ]),
        'filterModel' => new DesignacionSearch(),
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
              'attribute' => 'cargo_id',
              'format' => 'html',
              'value' => function($data){
                  return Cargo::findOne($data->cargo_id)->nomenclatura;
              }
            ],
            'user_id',
            [
              'class' => 'yii\grid\ActionColumn',
              'controller' => 'designacion',
              'template' => $show_this_nav? '{view} {delete} {update}':'{view}',

            ],
        ],
    ]); ?>

</div>
