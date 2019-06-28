<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use common\models\Departamento;
use common\models\Plan;
/* @var $this yii\web\View */
/* @var $model backend\models\Asignatura */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="asignatura-form">

    <?php $form = ActiveForm::begin(); ?>
     <div class="col-md-3">
        <?= $form->field($model, 'nomenclatura')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'departamento_id')->widget(Select2::classname(),[
            'data' => ArrayHelper::map(Departamento::find()->all(),'id','nomenclatura'),
            //'data' =>ArrayHelper::map(((new StatusSearch())->search(['model' => 'backend\models\Status'])),'id','descripcion'),
            //'data' => (new StatusSearch())->search(['model' => 'backend\models\Status'])->id,
            'language' => 'es',
            'options' => ['placeholder' => 'Seleccione un departamento...'],
            'pluginOptions' => [
              'allowClear' => true,
            ],
        ]) ?>
        <?= $form->field($model, 'carga_horaria_cuatr')->textInput() ?>
    </div>
    <div class="col-md-3">
        <?= $form->field($model, 'curso')->textInput() ?>
        <?= $form->field($model, 'cuatrimestre')->textInput() ?>
        <?= $form->field($model, 'carga_horaria_sem')->textInput() ?>
    </div>
    <div class="col-md-3">
        <?= $form->field($model, 'plan_id')->widget(Select2::classname(),[
            'data' => ArrayHelper::map(Plan::find()->all(),'id','ordenanza'),
            //'data' =>ArrayHelper::map(((new StatusSearch())->search(['model' => 'backend\models\Status'])),'id','descripcion'),
            //'data' => (new StatusSearch())->search(['model' => 'backend\models\Status'])->id,
            'language' => 'es',
            'options' => ['placeholder' => 'Seleccione un plan...'],
            'pluginOptions' => [
              'allowClear' => true,
            ],
        ]) ?>
        <?= $form->field($model, 'orden')->input('number') ?>

         <div class="form-group">
            <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
        </div>
    </div>
   

    		   

    		   

      


   

    <?php ActiveForm::end(); ?>

</div>
