<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Cargo */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="cargo-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'nomenclatura')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'carga_programa')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
