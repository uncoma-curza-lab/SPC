<?php
use froala\froalaeditor\FroalaEditorWidget;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
$this->params['breadcrumbs'][] = ['label' => '...'];
$this->params['breadcrumbs'][] = ['label' => "Contenido según plan de estudio", 'url' => ['contenido-plan', 'id' => $model->id]];
$this->params['breadcrumbs'][] = ['label' => "Contenidos analíticos", 'url' => ['contenido-analitico', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Propuesta metodológica';
 ?>
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
    <?= Html::submitButton('Seguir', ['class' => 'btn btn-success']) ?>
    <?= Html::a('Volver', ['contenido-analitico', 'id' => $model->id],['class' => 'btn btn-warning']) ?>
</div>
<?php ActiveForm::end(); ?>
