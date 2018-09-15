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

<h3>1. Fundamentación</h3>
<?= FroalaEditorWidget::widget([
            'model' => $model,
            'attribute' => 'fundament',
            'name' => 'fundament',
            'options' => [
                'id'=>'fundament'
            ]
]) ?>
<div class="form-group">
    <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
</div>
<?php ActiveForm::end(); ?>
