<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Asignatura */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="asignatura-form">

    <?php $form = ActiveForm::begin(); ?>
    <?= $form->field($model, 'curso')->textInput() ?>

    		   <?= $form->field($model, 'cuatrimestre')->textInput() ?>

    		   <?= $form->field($model, 'carga_horaria_sem')->textInput() ?>

    		   <?= $form->field($model, 'carga_horaria_cuatr')->textInput() ?>
              <?= $form->field($model, 'departamento_id')->textInput() ?> 
    <?= $form->field($model, 'nomenclatura')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'plan_id')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
