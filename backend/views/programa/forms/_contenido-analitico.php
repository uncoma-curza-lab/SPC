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

<h3>4. Contenidos analíticos</h3>
  <?= $this->render('_gridUnidades',['model' => $model]) ?>

 <p>
     <?= Html::a('Seguir', ['propuesta-metodologica' , 'id' => $model->id], ['class' => 'btn btn-success']) ?>
     <?= Html::a('Volver', ['contenido-plan', 'id' => $model->id],['class' => 'btn btn-warning']) ?>

 </p>
