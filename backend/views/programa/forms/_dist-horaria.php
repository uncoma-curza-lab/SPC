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

<h3>9. Distribución horaria</h3>
<?= FroalaEditorWidget::widget([
            'model' => $model,
            'attribute' => 'distr_horaria',
            'name' => 'distr_horaria',
            'options' => [
                'id'=>'distr_horaria'
            ]
]) ?>
<div class="form-group">
    <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
</div>
<?php ActiveForm::end(); ?>
