<?php
use unclead\multipleinput\MultipleInput;
use unclead\multipleinput\MultipleInputColumn;
use froala\froalaeditor\FroalaEditorWidget;
use yii\jui\DatePicker;
use yii\helpers\Html;
?>

<h3>4. Contenidos analíticos</h3>
  <?= $this->render('_gridUnidades',['model' => $model]) ?>

 <p>
     <?= Html::a('Guardar', ['propuesta-metodologica' , 'id' => $model->id], ['class' => 'btn btn-success']) ?>
 </p>
