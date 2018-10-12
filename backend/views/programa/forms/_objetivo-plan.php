<?php
use kartik\tabs\TabsX;
use froala\froalaeditor\FroalaEditorWidget;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
$this->params['breadcrumbs'][] = ['label' => '...'];
$this->params['breadcrumbs'][] = ['label' => "Portada", 'url' => ['update', 'id' => $model->id]];
$this->params['breadcrumbs'][] = ['label' => "Fundamentacion", 'url' => ['fundamentacion', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Objetivo según el plan de estudio';
?>
<div class="progress">
  <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width: 20%">
     20%
  </div>
</div>
<?php $form = ActiveForm::begin([
'enableAjaxValidation'      => false,
'enableClientValidation'    => false,
'validateOnChange'          => true,
'validateOnSubmit'          => false,
'validateOnBlur'            => false,
]); ?>

<h3>2. Objetivo según Plan de estudio</h3>

<?= FroalaEditorWidget::widget([
            'model' => $model,
            'attribute' => 'objetivo_plan',
            'name' => 'objetivo_plan',
            'options' => [
                'id'=>'objetivo_plan'
            ],
            'clientOptions' => [
              'placeholderText' => 'Se espera que los estudiantes puedan',
              'language' => 'es',
              'height' => 200,
              'theme' => 'gray',
              'toolbarButtons' => ['bold', 'italic', 'underline', '|','lineBreaker','paragraphFormat', 'fontSize','color','|','undo','redo','align'],
            ],
]) ?>
<br>

<div class="form-group">
    <div class="row">
      <div class="col-xs-6 text-left">
        <?= Html::a('Atrás', ['fundamentacion', 'id' => $model->id],['class' => 'btn btn-warning']) ?>
        <?= Html::submitButton('Guardar y salir',['class' => 'btn btn-info' , 'name'=>'submit','value' => 'salir']) ?>
      </div>
      <div class="col-xs-6 text-right">
        <?= Html::submitButton('Seguir', ['class' => 'btn btn-success']) ?>
      </div>
    </div>
</div>
<?php ActiveForm::end(); ?>
