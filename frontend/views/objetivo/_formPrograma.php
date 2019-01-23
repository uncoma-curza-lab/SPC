<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Objetivo */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="objetivo-form">

    <?php $form = ActiveForm::begin([
  
    ]); ?>

    <?= $form->field($modelObj, 'descripcion')->textInput(['maxlength' => true]) ?>


    <div class="form-group">
        <?= Html::submitButton('Submit'); ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
