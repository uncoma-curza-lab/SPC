<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Unidad */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="unidad-form">

    <?php $form = ActiveForm::begin(); ?>
    
    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?= $form->field($model, 'descripcion')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'biblio_basica')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'biblio_consulta')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'crono_tent')->textInput() ?>

    <?= $form->field($model, 'programa_id')->textInput() ?>

    <?php ActiveForm::end(); ?>

    <?= $this->renderAjax('_gridTemas',['model' => $model]) ?>

</div>
