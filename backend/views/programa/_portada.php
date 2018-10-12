<?php
  use yii\helpers\Html;
  use yii\widgets\ActiveForm;
  use kartik\select2\Select2;
  use yii\helpers\ArrayHelper;
  use unclead\multipleinput\MultipleInput;
  use backend\models\Departamento;
  use backend\models\Carrera;
  use yii\widgets\Pjax;

  use backend\models\Status;
?>

<br>
<div class="progress">
  <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="1" aria-valuemin="0" aria-valuemax="100" style="width: 1%">
     1%
  </div>
</div>
<?php Pjax::begin(); ?>

<?php $form = ActiveForm::begin([
  'enableAjaxValidation'      => false,
  'enableClientValidation'    => false,
  'validateOnChange'          => true,
  'validateOnSubmit'          => false,
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
  <div class="col-xs-4">
    <?= $form->field($model, 'carreras')->widget(Select2::classname(),[
        'data' => ArrayHelper::map(Carrera::find()->all(),'id','nom'),
        'language' => 'es',
        'options' => ['placeholder' => 'Seleccione las carreras'],
        'pluginOptions' => [
          'allowClear' => true,
          'multiple' => true
        ],
      ]) ?>
  </div>
  <div class="col-xs-2">
    <?= $form->field($model, 'cuatrimestre')->widget(Select2::classname(),[
        'data' => [1=>'1',2=>'2'],
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
  <?= $this->render('forms/_gridCargos',['model' => $model]) ?>

</div>

<div class="row">
  <div class="col-xs-6">
    <!--<?// $form->field($model, 'profadj_regular')->textInput(['maxlength' => true]) ?>-->
  </div>
  <div class="col-xs-6">
    <!--<?// $form->field($model, 'asist_regular')->textInput(['maxlength' => true]) ?>-->
  </div>
</div>
<div class="row">
  <div class="col-xs-6">
    <!--<?// $form->field($model, 'ayudante_p')->textInput(['maxlength' => true]) ?>-->
<!--    <?// $form->field($model, 'ayudante_p')->widget(MultipleInput::Classname(),
      [
        'name' => 'ayudante_p',
      ]) ?>-->
  </div>
  <div class="col-xs-6">
    <!--<?// $form->field($model, 'ayudante_s')->textInput(['maxlength' => true]) ?>-->
  </div>
</div>


<div class="form-group">
    <div class="row">
      <div class="col-xs-6 text-left">
        <?= Html::a('Salir', ['index'],['class' => 'btn btn-warning']) ?>
        <?= Html::submitButton('Guardar y salir',['class' => 'btn btn-info' , 'name'=>'submit','value' => 'salir']) ?>
      </div>
      <div class="col-xs-6 text-right">
        <?= Html::submitButton('Seguir', ['class' => 'btn btn-success']) ?>
      </div>
    </div>
</div>
<?php ActiveForm::end(); ?>
<?php Pjax::end(); ?>
