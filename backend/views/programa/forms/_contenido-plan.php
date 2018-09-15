<?php
use froala\froalaeditor\FroalaEditorWidget;
use yii\helpers\Html;

use yii\widgets\ActiveForm;
 ?>
 <?php $form = ActiveForm::begin([
   'enableAjaxValidation'      => true,
   'enableClientValidation'    => false,
   'validateOnChange'          => false,
   'validateOnSubmit'          => true,
   'validateOnBlur'            => false,
 ]); ?>

<h3>3. Contenido según Plan de Estudio</h3>
<?= FroalaEditorWidget::widget([
            'model' => $model,
            'attribute' => 'contenido_plan',
            'name' => 'contenido_plan',
            'options' => [
                'id'=>'contenido_plan'
            ]
]) ?>
<div class="form-group">
    <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
</div>
<?php ActiveForm::end(); ?>
