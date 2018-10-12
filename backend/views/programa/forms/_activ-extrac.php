<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use froala\froalaeditor\FroalaEditorWidget;
$this->params['breadcrumbs'][] = ['label' => '...'];
$this->params['breadcrumbs'][] = ['label' => "Distribución Horaria", 'url' => ['dist-horaria', 'id' => $model->id]];
$this->params['breadcrumbs'][] = ['label' => "Cronograma tentativo", 'url' => ['crono-tentativo', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Activadades extracurriculares';
 ?>
 <?php $form = ActiveForm::begin([
   'enableAjaxValidation'      => false,
   'enableClientValidation'    => false,
   'validateOnChange'          => true,
   'validateOnSubmit'          => false,
   'validateOnBlur'            => false,
 ]); ?>

 <div class="progress">
   <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="99" aria-valuemin="0" aria-valuemax="100" style="width: 99%">
      99%
   </div>
 </div>
<h3>10. Planificación de actividades Extracurriculares</h3>
<?= FroalaEditorWidget::widget([
            'model' => $model,
            'attribute' => 'actv_extracur',
            'name' => 'actv_extracur',
            'options' => [
                'id'=>'actv_extracur'
            ],
            'clientOptions' => [
              'placeholderText' => 'Se prevé la participación de la cátedra en la organización de las Jornadas ..... Asimismo las actividades de extensión de cátedra',
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
        <?= Html::a('Atrás', ['crono-tentativo', 'id' => $model->id],['class' => 'btn btn-warning']) ?>
        <?= Html::submitButton('Guardar y salir',['class' => 'btn btn-info' , 'name'=>'submit','value' => 'salir']) ?>
      </div>
      <div class="col-xs-6 text-right">
        <?= Html::submitButton('Terminar', ['class' => 'btn btn-success']) ?>
      </div>
    </div>
</div>
<?php ActiveForm::end(); ?>
