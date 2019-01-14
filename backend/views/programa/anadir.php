<?php
  use yii\helpers\Html;
  use yii\widgets\ActiveForm;
  use kartik\select2\Select2;
  use yii\helpers\ArrayHelper;
  use backend\models\Asignatura;

?>
<br>
<div class="progress">
  <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="1" aria-valuemin="0" aria-valuemax="100" style="width: 1%">
     1%
  </div>
</div>
<?php $form = ActiveForm::begin(); ?>
<?= $form->field($model, 'year')->textInput(['maxlength' => true]) ?>

<?= $form->field($model, 'asignatura_id')->widget(Select2::classname(),[
    'data' => ArrayHelper::map(Asignatura::find()->where(['departamento_id' => $deptoId])->all(),'id','nomenclatura'),
    //'data' =>ArrayHelper::map(((new StatusSearch())->search(['model' => 'backend\models\Status'])),'id','descripcion'),
    //'data' => (new StatusSearch())->search(['model' => 'backend\models\Status'])->id,

    'language' => 'es',
    'options' => ['placeholder' => 'Seleccione una asignatura'],
    'pluginOptions' => [
      'allowClear' => true,
    ],
  ]) ?>
  <div class="form-group">
      <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
  </div>

  <?php ActiveForm::end(); ?>
