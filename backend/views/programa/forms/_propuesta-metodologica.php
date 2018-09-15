<?php
use froala\froalaeditor\FroalaEditorWidget;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
 ?>
<h3>6. Propuesta Metodológica</h3>
<?php $form = ActiveForm::begin([
  'enableAjaxValidation'      => true,
  'enableClientValidation'    => false,
  'validateOnChange'          => false,
  'validateOnSubmit'          => true,
  'validateOnBlur'            => false,
]); ?>
<?= FroalaEditorWidget::widget([
            'model' => $model,
            'attribute' => 'propuesta_met',
            'name' => 'propuesta_met',
            'options' => [
                'id'=>'propuesta_met'
            ]
]) ?>
<div class="form-group">
    <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
</div>
<?php ActiveForm::end(); ?>
