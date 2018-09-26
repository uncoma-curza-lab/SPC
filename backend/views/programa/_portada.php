<?php
  use yii\helpers\Html;
  use yii\widgets\ActiveForm;
  use kartik\select2\Select2;
  use yii\helpers\ArrayHelper;
  use backend\models\Departamento;
  use backend\models\Status;
?>
<div class="progress">
  <div class="progress-bar progress-bar-success progress-bar-striped active" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%">
     0%
  </div>
</div>
<?php $form = ActiveForm::begin([
  'enableAjaxValidation'      => true,
  'enableClientValidation'    => false,
  'validateOnChange'          => false,
  'validateOnSubmit'          => true,
  'validateOnBlur'            => false,
]); ?>

<div class="row">
  <div class="col-xs-3">
    <?= $form->field($model, 'departamento_id')->widget(Select2::classname(),[
        'data' => ArrayHelper::map(Departamento::find()->all(),'id','nom'),
        'language' => 'es',
        'options' => ['placeholder' => 'Seleccione un departamento'],
        'pluginOptions' => [
          'allowClear' => true,
        ],
      ]) ?>

  </div>
  <div class="col-xs-4">
    <?= $form->field($model, 'status_id')->widget(Select2::classname(),[
        'data' => ArrayHelper::map(Status::find()->all(),'id','descripcion'),
        'language' => 'es',
        'options' => ['placeholder' => 'Seleccione un estado'],
        'pluginOptions' => [
          'allowClear' => true,
        ],
      ]) ?>
  </div>

  <div class="col-xs-2">
    <?= $form->field($model, 'cuatrimestre')->widget(Select2::classname(),[
        'data' => [1,2],
        'language' => 'es',
        'options' => ['placeholder' => 'Seleccione un CUATRIMESTRE'],
        'pluginOptions' => [
          'allowClear' => true,
        ],
      ]) ?>
  </div>

  <div class="col-xs-2">
    <?= $form->field($model, 'year')->textInput(['maxlength' => true]) ?>
  </div>

</div>
<div class="row">
  <div class="col-xs-4">
    <?= $form->field($model, 'curso')->textInput(['maxlength' => true]) ?>
  </div>
  <div class="col-xs-4">
    <?= $form->field($model, 'asignatura')->textInput(['maxlength' => true]) ?>
  </div>
</div>
<hr>
<div class="row">
  <div class="col-xs-6">
    <?= $form->field($model, 'profadj_regular')->textInput(['maxlength' => true]) ?>
  </div>
  <div class="col-xs-6">
    <?= $form->field($model, 'asist_regular')->textInput(['maxlength' => true]) ?>
  </div>
</div>
<div class="row">
  <div class="col-xs-6">
    <?= $form->field($model, 'ayudante_p')->textInput(['maxlength' => true]) ?>
  </div>
  <div class="col-xs-6">
    <?= $form->field($model, 'ayudante_s')->textInput(['maxlength' => true]) ?>
  </div>
</div>


<div class="form-group">
    <div class="row">
      <div class="col-xs-6 text-left">
        <?= Html::a('Salir', ['index'],['class' => 'btn btn-warning']) ?>
      </div>
      <div class="col-xs-6 text-right">
        <?= Html::submitButton('Seguir', ['class' => 'btn btn-success']) ?>
      </div>
    </div>
</div>
<?php ActiveForm::end(); ?>
