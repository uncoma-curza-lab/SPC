<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\ProgramaSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="programa-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'departamento_id') ?>

    <?= $form->field($model, 'status_id') ?>

    <?= $form->field($model, 'asignatura_id') ?>


    <?php // echo $form->field($model, 'year') ?>

    <?php // echo $form->field($model, 'cuatrimestre') ?>

    <?php // echo $form->field($model, 'fundament') ?>

    <?php // echo $form->field($model, 'objetivo_plan') ?>

    <?php // echo $form->field($model, 'contenido_plan') ?>

    <?php // echo $form->field($model, 'propuesta_met') ?>

    <?php // echo $form->field($model, 'evycond_acreditacion') ?>

    <?php // echo $form->field($model, 'parcial_rec_promo') ?>

    <?php // echo $form->field($model, 'distr_horaria') ?>

    <?php // echo $form->field($model, 'crono_tentativo') ?>

    <?php // echo $form->field($model, 'actv_extracur') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <?php // echo $form->field($model, 'created_by') ?>

    <?php // echo $form->field($model, 'updated_by') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
