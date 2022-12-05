<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\TimeDistribution */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="time-distribution-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'module_id')->textInput() ?>

    <?= $form->field($model, 'lesson_type_id')->textInput() ?>

    <?= $form->field($model, 'percentage_quantity')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
