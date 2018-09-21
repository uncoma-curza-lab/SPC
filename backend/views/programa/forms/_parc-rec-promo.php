<?php
use froala\froalaeditor\FroalaEditorWidget;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
$this->params['breadcrumbs'][] = ['label' => '...'];
$this->params['breadcrumbs'][] = ['label' => "Propuesta metodológica", 'url' => ['propuesta-metodologica', 'id' => $model->id]];
$this->params['breadcrumbs'][] = ['label' => "Evaluacion y acreditación", 'url' => ['eval-acred', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Parciales, recuperatorios y coloquios';
?>
<?php $form = ActiveForm::begin([
  'enableAjaxValidation'      => true,
  'enableClientValidation'    => false,
  'validateOnChange'          => false,
  'validateOnSubmit'          => true,
  'validateOnBlur'            => false,
]); ?>
<h3>7. Parciales, Recuperatorios y coloquios</h3>

<?= FroalaEditorWidget::widget([
            'model' => $model,
            'attribute' => 'parcial_rec_promo',
            'name' => 'parcial_rec_promo',
            'options' => [
                'id'=>'parcial_rec_promo'
            ],
            'clientOptions' => [
              'placeholderText' => 'Establecer fechas para los parciales, recuperatorios y coloquios, así como las condiciones y unidades que corresponden.',
              'height' => 100,
              'language' => 'es',
              'height' => 100,
              'theme' => 'gray',
              'toolbarButtons' => ['bold', 'italic', 'underline', '|', 'paragraphFormat', 'fontSize','color','|','undo','redo','align'],
            ],
]) ?>
<br>
<div class="form-group">
    <?= Html::submitButton('Seguir', ['class' => 'btn btn-success']) ?>
    <?= Html::a('Volver', ['eval-acred', 'id' => $model->id],['class' => 'btn btn-warning']) ?>
</div>
<?php ActiveForm::end(); ?>
