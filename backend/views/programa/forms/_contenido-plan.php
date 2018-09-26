<?php
use froala\froalaeditor\FroalaEditorWidget;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->params['breadcrumbs'][] = ['label' => '...'];
$this->params['breadcrumbs'][] = ['label' => "Fundamentacion", 'url' => ['fundamentacion', 'id' => $model->id]];
$this->params['breadcrumbs'][] = ['label' => "Obj. según el plan de estudio", 'url' => ['objetivo-plan', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Contenido según el plan de estudio';
 ?>
 <div class="progress">
   <div class="progress-bar progress-bar-success progress-bar-striped active" role="progressbar" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100" style="width: 30%">
      30%
   </div>
 </div>
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
            ],
            'clientOptions' => [
              'placeholderText' => 'son los referidos al plan de estudios tal lo allí establecido.',
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
      <?= Html::a('Volver', ['objetivo-plan', 'id' => $model->id],['class' => 'btn btn-warning']) ?>
    </div>
    <div class="col-xs-6 text-right">
      <?= Html::submitButton('Seguir', ['class' => 'btn btn-success']) ?>
    </div>
  </div>
</div>
<?php ActiveForm::end(); ?>
