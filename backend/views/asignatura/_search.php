<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\AsignaturaSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="asignatura-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'nomenclatura') ?>

    <?= $form->field($model, 'curso') ?>

		   <?= $form->field($model, 'cuatrimestre') ?>

		   <?= $form->field($model, 'carga_horaria_sem') ?>

		   <?php // echo $form->field($model, 'carga_horaria_cuatr') ?>

		   <?php  echo $form->field($model, 'plan_id') ?>

		   <?php  echo $form->field($model, 'departamento_id') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
