<?php

use yii\helpers\Html;
use yii\grid\GridView;
use common\models\Designacion;
use common\models\Cargo;
use common\models\Status;
use common\models\Persona;
use common\models\PermisosHelpers;
use common\models\search\DesignacionSearch;
use yii\data\ActiveDataProvider;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\UnidadSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$show_this_nav = (Status::findOne($model->status_id)->descripcion == "Borrador") &&
                  (PermisosHelpers::requerirDirector($model->id));
?>
<div class="col align-self-center">

  <div  class="cargos-index">


      <?= GridView::widget([
          'dataProvider' => new ActiveDataProvider([
            'query' => $model->getDesignaciones()
          ]),
    //      'filterModel' => new DesignacionSearch(),
          'columns' => [
        //      ['class' => 'yii\grid\SerialColumn'],
              [
                'attribute' => 'cargo_id',
                'format' => 'html',
                'value' => function($data){
                    $cargo =  Cargo::findOne($data->cargo_id);
                    return isset($cargo) ? $cargo->nomenclatura : "N/N";
                }
              ],
              'user_id',
              [
                'class' => 'yii\grid\ActionColumn',
                'controller' => 'designacion',
                'template' => $show_this_nav? '{view} {delete}':'{view}',

              ],
          ],
      ]); ?>
      <?php if($show_this_nav): ?>

      <p class="pull-right">
          <?= Html::a('Agregar una designación', ['designacion/asignar', 'id' => $model->id], ['class' => 'btn btn-success']) ?>
      </p>
<br>
<br>
      <?php endif; ?>
  </div>
</div>
