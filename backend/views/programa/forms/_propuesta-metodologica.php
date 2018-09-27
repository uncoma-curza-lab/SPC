<?php
use froala\froalaeditor\FroalaEditorWidget;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
$this->params['breadcrumbs'][] = ['label' => '...'];
$this->params['breadcrumbs'][] = ['label' => "Contenido según plan de estudio", 'url' => ['contenido-plan', 'id' => $model->id]];
$this->params['breadcrumbs'][] = ['label' => "Contenidos analíticos", 'url' => ['contenido-analitico', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Propuesta metodológica';
 ?>
 <div class="progress">
   <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width: 50%">
      50%
   </div>
 </div>
<h3>5. Propuesta Metodológica</h3>
<?php $form = ActiveForm::begin([
  'enableAjaxValidation'      => true,
  'enableClientValidation'    => false,
  'validateOnChange'          => false,
  'validateOnSubmit'          => true,
  'validateOnBlur'            => false,
]); ?>
<?= FroalaEditorWidget::widget([
            'model' => $model,
            'attribute' => 'propuesta_met',
            'name' => 'propuesta_met',
            'options' => [
                'id'=>'propuesta_met'
            ],
            'clientOptions' => [
              'placeholderText' => 'Señalar la metodología en general y el plan de trabajos prácticos. se recomienda establecer una actividad para promover la escritura académica como línea de fortalecimiento institucional de la formación de nuestros estudiantes.',
              'height' => 100,
              'language' => 'es',
              'height' => 100,
              'theme' => 'gray',
              'toolbarButtons' => ['bold', 'italic', 'underline', '|', 'paragraphFormat', 'fontSize','color','|','undo','redo','align'],
            ],
]) ?>
<br>

<div class="form-group">
    <div class="row">
      <div class="col-xs-6 text-left">
        <?= Html::a('Volver', ['contenido-analitico', 'id' => $model->id],['class' => 'btn btn-warning']) ?>
        <?= Html::submitButton('Guardar y salir',['class' => 'btn btn-info' , 'name'=>'submit','value' => 'salir']) ?>
      </div>
      <div class="col-xs-6 text-right">
        <?= Html::submitButton('Seguir', ['class' => 'btn btn-success']) ?>
      </div>
    </div>
</div>
<?php ActiveForm::end(); ?>
