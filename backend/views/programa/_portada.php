<?php
  use yii\helpers\Html;
  use yii\widgets\ActiveForm;
  use kartik\select2\Select2;
  use yii\helpers\ArrayHelper;
  use backend\models\Departamento;
?>
<?php $form = ActiveForm::begin(); ?>

<?= $form->field($model, 'departamento_id')->widget(Select2::classname(),[
    'data' => ArrayHelper::map(Departamento::find()->all(),'id','nom'),
    'language' => 'es',
    'options' => ['placeholder' => 'Seleccione un departamento'],
    'pluginOptions' => [
      'allowClear' => true,
    ],
  ]) ?>


<?= $form->field($model, 'curso')->textInput(['maxlength' => true]) ?>

<?= $form->field($model, 'year')->textInput(['maxlength' => true]) ?>

<?= $form->field($model, 'cuatrimestre')->textInput() ?>

<?= $form->field($model, 'profadj_regular')->textInput(['maxlength' => true]) ?>

<?= $form->field($model, 'asist_regular')->textInput(['maxlength' => true]) ?>

<?= $form->field($model, 'ayudante_p')->textInput(['maxlength' => true]) ?>

<?= $form->field($model, 'ayudante_s')->textInput(['maxlength' => true]) ?>
<?php ActiveForm::end(); ?>
