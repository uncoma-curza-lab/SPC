<?php
  use froala\froalaeditor\FroalaEditorWidget;
  use yii\helpers\Html;
  use yii\widgets\ActiveForm;

  $this->params['breadcrumbs'][] = ['label' => 'Programas', 'url' => ['index']];
  $this->params['breadcrumbs'][] = ['label' =>  $model->getDepartamento()->one()->nom . " " . $model->curso, 'url' => ['view', 'id' => $model->id]];
  $this->params['breadcrumbs'][] = ['label' => "Portada", 'url' => ['update', 'id' => $model->id]];

  $this->params['breadcrumbs'][] = 'Fundamentacion';
?>
<div class="progress">
  <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100" style="width: 10%">
     10%
  </div>
</div>
<?php $form = ActiveForm::begin([
  'enableAjaxValidation'      => false,
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
              'height' => 300,
              'language' => 'es',
              'theme' => 'gray',
              'toolbarButtons' => ['bold', 'italic', 'underline', '|', 'paragraphFormat', 'fontSize','color','|','undo','redo','align'],
            ],
]) ?>
<br>

<div class="form-group">
  <div class="row">
    <div class="col-xs-6 text-left">
      <?= Html::a('Atrás', ['update', 'id' => $model->id],['class' => 'btn btn-warning']) ?>
        <?= Html::submitButton('Guardar y salir',['class' => 'btn btn-info' , 'name'=>'submit','value' => 'salir']) ?>
    </div>
    <div class="col-xs-6 text-right">
      <?= Html::submitButton('Seguir', ['class' => 'btn btn-success']) ?>
    </div>
  </div>
</div>
<?php ActiveForm::end(); ?>
