<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use froala\froalaeditor\FroalaEditorWidget;
 ?>
 <?php $form = ActiveForm::begin([
   'enableAjaxValidation'      => true,
   'enableClientValidation'    => false,
   'validateOnChange'          => false,
   'validateOnSubmit'          => true,
   'validateOnBlur'            => false,
 ]); ?>

<h3>11. Planificación de actividades Extracurriculares</h3>
<?= FroalaEditorWidget::widget([
            'model' => $model,
            'attribute' => 'actv_extracur',
            'name' => 'actv_extracur',
            'options' => [
                'id'=>'actv_extracur'
            ]
]) ?>
<div class="form-group">
    <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
</div>
<?php ActiveForm::end(); ?>
