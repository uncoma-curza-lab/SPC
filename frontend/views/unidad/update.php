<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Unidad */

$this->title = 'Unidad: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Unidads', 'url' => ['programa/contenido-analitico','id' => $model->programa_id]];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>


<div class="unidad-update">

    <div class="row">
      <div class="col-xs-6">
      </div>
      <div class="col-xs-6">
        <div class="text-right">
          <?= Html::a('Volver a unidades', ['programa/contenido-analitico','id' => $model->programa_id],['class' => 'btn btn-warning']) ?>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-xs-4">
        <h1><?= Html::encode($this->title) ?></h1>

        <?= DetailView::widget([
            'model' => $model,
            'attributes' => [
              [
                'attribute' => 'descripcion',
                'format' => 'html',
                'value' => function($data){
                  if(strlen($data->descripcion) > 40){
                    return substr($data->descripcion,0,600)."...";
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
                    return substr($data->biblio_basica,0,200)."...";
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

            ],
        ]) ?>
        <?= Html::a('Editar información de unidad', ['unidad/edit','id' => $model->id],['class' => 'btn btn-info']) ?>

      </div>
      <div class="col-xs-8">
        <?php if ( isset($model->id) ) {?>
        <h1>Temas</h1>
        <?= $this->render('_gridTemas',['model' => $model]) ?>
        <?php } ?>

      </div>
    </div>




</div>
