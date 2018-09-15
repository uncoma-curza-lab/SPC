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
<h3>7. Evaluación y condiciones de acreditación</h3>
<?= FroalaEditorWidget::widget([
            'model' => $model,
            'attribute' => 'evycond_acreditacion',
            'name' => 'evycond_acreditacion',
            'options' => [
                'id'=>'evycond_acreditacion'
            ]
]) ?>
<div class="form-group">
    <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
</div>
<?php ActiveForm::end(); ?>
