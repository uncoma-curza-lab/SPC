<?php
use unclead\multipleinput\MultipleInput;
use unclead\multipleinput\MultipleInputColumn;
use froala\froalaeditor\FroalaEditorWidget;
use yii\jui\DatePicker;
use yii\helpers\Html;
$this->params['breadcrumbs'][] = ['label' => '...'];
$this->params['breadcrumbs'][] = ['label' => "Obj. según el plan de estudio", 'url' => ['objetivo-plan', 'id' => $model->id]];
$this->params['breadcrumbs'][] = ['label' => "Contenido según plan de estudio", 'url' => ['contenido-plan', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Contenidos analíticos';
?>
<div class="progress">
  <div class="progress-bar progress-bar-success progress-bar-striped active" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 40%">
     40%
  </div>
</div>
<h3>4. Contenidos analíticos</h3>
  <?= $this->render('_gridUnidades',['model' => $model]) ?>

<br>
   <div class="row">
     <div class="col-xs-6 text-left">
       <?= Html::a('Volver', ['contenido-plan', 'id' => $model->id],['class' => 'btn btn-warning']) ?>
     </div>
     <div class="col-xs-6 text-right">
       <?= Html::a('Seguir', ['propuesta-metodologica' , 'id' => $model->id], ['class' => 'btn btn-success']) ?>
     </div>
   </div>
