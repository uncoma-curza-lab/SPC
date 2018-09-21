<?php
  use froala\froalaeditor\FroalaEditorWidget;
  use yii\helpers\Html;
  use yii\widgets\ActiveForm;

  $this->params['breadcrumbs'][] = ['label' => 'Programas', 'url' => ['index']];
  $this->params['breadcrumbs'][] = ['label' =>  $model->getDepartamento()->one()->nom . " " . $model->curso, 'url' => ['view', 'id' => $model->id]];
  $this->params['breadcrumbs'][] = ['label' => "Portada", 'url' => ['update', 'id' => $model->id]];

  $this->params['breadcrumbs'][] = 'Fundamentacion';
?>
<?php $form = ActiveForm::begin([
  'enableAjaxValidation'      => true,
  'enableClientValidation'    => false,
  'validateOnChange'          => false,
  'validateOnSubmit'          => true,
  'validateOnBlur'            => false,
]); ?>

<h3>1. Fundamentación</h3>
<?= FroalaEditorWidget::widget([
            'model' => $model,
            'attribute' => 'fundament',
            'name' => 'fundament',

            'options' => [
                'id'=>'fundament'
            ],
            'clientOptions' => [
              'placeholderText' => 'Ubicación de la asignatura dentro del Plan de estudios. Correlativas anteriores y posteriores. Sentido de la asignatura. Propósitos y estructura del programa.',
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
    <?= Html::a('Volver', ['update', 'id' => $model->id],['class' => 'btn btn-warning']) ?>
</div>
<?php ActiveForm::end(); ?>
