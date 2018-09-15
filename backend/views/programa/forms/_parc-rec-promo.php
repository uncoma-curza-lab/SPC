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
<h3>8. Parciales, Recuperatorios y coloquios</h3>

<?= FroalaEditorWidget::widget([
            'model' => $model,
            'attribute' => 'parcial_rec_promo',
            'name' => 'parcial_rec_promo',
            'options' => [
                'id'=>'parcial_rec_promo'
            ]
]) ?>
<div class="form-group">
    <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
</div>
<?php ActiveForm::end(); ?>
