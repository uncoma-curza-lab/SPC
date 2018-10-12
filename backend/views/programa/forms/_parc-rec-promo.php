<?php
use froala\froalaeditor\FroalaEditorWidget;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
$this->params['breadcrumbs'][] = ['label' => '...'];
$this->params['breadcrumbs'][] = ['label' => "Propuesta metodológica", 'url' => ['propuesta-metodologica', 'id' => $model->id]];
$this->params['breadcrumbs'][] = ['label' => "Evaluacion y acreditación", 'url' => ['eval-acred', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Parciales, recuperatorios y coloquios';
?>
<div class="progress">
  <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100" style="width: 70%">
     70%
  </div>
</div>
<?php $form = ActiveForm::begin([
  'enableAjaxValidation'      => false,
  'enableClientValidation'    => false,
  'validateOnChange'          => true,
  'validateOnSubmit'          => false,
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
    <div class="row">
      <div class="col-xs-6 text-left">
        <?= Html::a('Atrás', ['eval-acred', 'id' => $model->id],['class' => 'btn btn-warning']) ?>
        <?= Html::submitButton('Guardar y salir',['class' => 'btn btn-info' , 'name'=>'submit','value' => 'salir']) ?>
      </div>
      <div class="col-xs-6 text-right">
        <?= Html::submitButton('Seguir', ['class' => 'btn btn-success']) ?>
      </div>
    </div>
</div>
<?php ActiveForm::end(); ?>
