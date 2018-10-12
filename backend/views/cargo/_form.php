<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Cargo */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="cargo-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'designacion')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'persona_id')->textInput() ?>

    <?= $form->field($model, 'programa_id')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
