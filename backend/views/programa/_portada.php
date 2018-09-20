<?php
  use yii\helpers\Html;
  use yii\widgets\ActiveForm;
  use kartik\select2\Select2;
  use yii\helpers\ArrayHelper;
  use backend\models\Departamento;
?>
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

  <div class="col-xs-3">
    <?= $form->field($model, 'cuatrimestre')->textInput() ?>
  </div>
  <div class="col-xs-2">
    <?= $form->field($model, 'year')->textInput(['maxlength' => true]) ?>
  </div>
  <div class="col-xs-4">
    <?= $form->field($model, 'curso')->textInput(['maxlength' => true]) ?>
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
    <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
</div>
<?php ActiveForm::end(); ?>
