<?php
use froala\froalaeditor\FroalaEditorWidget;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
$mensaje = [ 'onclick'=>"return confirm('No se guardarán los cambios de esta pestaña, ¿desea salir?')"];
$this->params['items'][] = ['label' => 'Portada', 'url' => Url::to(['update', 'id' => $model->id]), 'options'=> $mensaje ];
$this->params['items'][] = ['label' => '1. Fundamentación','url' => Url::to(['fundamentacion', 'id' => $model->id]), 'options'=>[ 'onclick'=>"return confirm('No se guardarán los cambios de esta pestaña, ¿desea salir?')"]];
$this->params['items'][] = ['label' => '2. Objetivo según plan de estudio', 'url' => Url::to(['objetivo-plan', 'id' => $model->id]), 'options'=> $mensaje];
$this->params['items'][] = ['label' => '3. Contenido según plan de estudio'];
$this->params['items'][] = ['label' => '4. Contenidos analíticos', 'url' => Url::to(['contenido-analitico', 'id' => $model->id]), 'options'=> $mensaje];
$this->params['items'][] = ['label' => '5. Propuesta Metodológica', 'url' => Url::to(['propuesta-metodologica', 'id' => $model->id]), 'options'=> $mensaje];
$this->params['items'][] = ['label' => '6. Evaluación y cond. de acreditación', 'url' => Url::to(['eval-acred', 'id' => $model->id]), 'options'=> $mensaje];
$this->params['items'][] = ['label' => '7. Parciales, recuperatorios y promociones', 'url' => Url::to(['parcial-rec-promo', 'id' => $model->id]), 'options'=> $mensaje];
$this->params['items'][] = ['label' => '8. Distribución horaria', 'url' => Url::to(['dist-horaria', 'id' => $model->id]), 'options'=> $mensaje];
$this->params['items'][] = ['label' => '9. Cronograma tentativo', 'url' => Url::to(['crono-tentativo', 'id' => $model->id]), 'options'=> $mensaje];
$this->params['items'][] = ['label' => '10. Actividad extracurricular', 'url' => Url::to(['actividad-extracurricular', 'id' => $model->id]), 'options'=> $mensaje];
$this->params['breadcrumbs'][] = ['label' => '...'];
$this->params['breadcrumbs'][] = ['label' => "Fundamentacion", 'url' => ['fundamentacion', 'id' => $model->id]];
$this->params['breadcrumbs'][] = ['label' => "Obj. según el plan de estudio", 'url' => ['objetivo-plan', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Contenido según el plan de estudio';
 ?>
 <div class="progress">
   <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100" style="width: 30%">
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
      <?= Html::a('Atrás', ['objetivo-plan', 'id' => $model->id],['class' => 'btn btn-warning']) ?>
      <?= Html::submitButton('Guardar y salir',['class' => 'btn btn-info' , 'name'=>'submit','value' => 'salir']) ?>
    </div>
    <div class="col-xs-6 text-right">
      <?= Html::submitButton('Seguir', ['class' => 'btn btn-success']) ?>
    </div>
  </div>
</div>
<?php ActiveForm::end(); ?>
