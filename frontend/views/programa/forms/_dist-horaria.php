<?php
use froala\froalaeditor\FroalaEditorWidget;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
$mensaje = [ 'onclick'=>"return confirm('No se guardarán los cambios de esta pestaña, ¿desea salir?')"];
$this->params['items'][] = ['label' => 'Portada' , 'url' => Url::to(['update', 'id' => $model->id]), 'options'=> $mensaje];
$this->params['items'][] = ['label' => '1. Fundamentación','url' => Url::to(['cargar', 'id' => $model->id]), 'options'=>[ 'onclick'=>"return confirm('No se guardarán los cambios de esta pestaña, ¿desea salir?')"]];
$this->params['items'][] = ['label' => '2. Objetivo según plan de estudio', 'url' => Url::to(['objetivo-plan', 'id' => $model->id]), 'options'=> $mensaje];
$this->params['items'][] = ['label' => '3. Contenido según plan de estudio', 'url' => Url::to(['contenido-plan', 'id' => $model->id]), 'options'=> $mensaje];
$this->params['items'][] = ['label' => '4. Contenidos analíticos', 'url' => Url::to(['contenido-analitico', 'id' => $model->id]), 'options'=> $mensaje];
$this->params['items'][] = ['label' => '5. Propuesta Metodológica', 'url' => Url::to(['propuesta-metodologica', 'id' => $model->id]), 'options'=> $mensaje];
$this->params['items'][] = ['label' => '6. Evaluación y cond. de acreditación', 'url' => Url::to(['eval-acred', 'id' => $model->id]), 'options'=> $mensaje];
$this->params['items'][] = ['label' => '7. Parciales, recuperatorios y promociones', 'url' => Url::to(['parcial-rec-promo', 'id' => $model->id]), 'options'=> $mensaje];
$this->params['items'][] = ['label' => '8. Distribución horaria'];
$this->params['items'][] = ['label' => '9. Cronograma tentativo', 'url' => Url::to(['crono-tentativo', 'id' => $model->id]), 'options'=> $mensaje];
$this->params['items'][] = ['label' => '10. Actividad extracurricular', 'url' => Url::to(['actividad-extracurricular', 'id' => $model->id]), 'options'=> $mensaje];
$this->params['breadcrumbs'][] = ['label' => '...'];
$this->params['breadcrumbs'][] = ['label' => "Evaluacion y acreditación", 'url' => ['eval-acred', 'id' => $model->id]];
$this->params['breadcrumbs'][] = ['label' => "Parciales, recuperatorios y coloquios", 'url' => ['parc-rec-promo', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Distribución Horaria';
$porcentaje = $model->calcularPorcentajeCarga();
 ?>
 <div class="row">
   <div class="col-md-2 text-right">
     <label>Programa completado: </label>
   </div>
   <div class="col-md-10 ">
     <div class="progress">
       <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="<?= $porcentaje ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?= $porcentaje ?>%">
          <?= $porcentaje ?>%
       </div>
     </div>
   </div>
 </div>
 <?php $form = ActiveForm::begin([
   'enableAjaxValidation'      => false,
   'enableClientValidation'    => false,
   'validateOnChange'          => true,
   'validateOnSubmit'          => false,
   'validateOnBlur'            => false,

 ]); ?>

<h3>8. Distribución horaria</h3>

<?= $form->field($model, 'distr_horaria')->widget(FroalaEditorWidget::classname(),[
            'model' => $model,
            'attribute' => 'distr_horaria',
            'name' => 'distr_horaria',
            'options' => [
                'id'=>'distr_horaria'
            ],
            'clientOptions' => [
              'placeholderText' => 'Según horas semanales establecidas por plan de estudio.',
              'height' => 100,
              'language' => 'es',
              'height' => 100,
              'theme' => 'gray',
              'toolbarButtons' => ['bold', 'italic', 'underline', '|', 'paragraphFormat', 'fontSize','color','|','undo','redo','align'],
            ],
])->label('') ?>
<br>

<div class="row">
  <div class="col-xs-6 text-left">
      <?= Html::a('Atrás', ['parcial-rec-promo', 'id' => $model->id],['onclick'=>"return confirm('No se guardarán los cambios de esta sección, ¿desea salir?')",'class' => 'btn btn-warning']) ?>
      <?= Html::submitButton('Guardar y salir',['class' => 'btn btn-info' , 'name'=>'submit','value' => 'salir']) ?>
  </div>
  <div class="col-xs-6 text-right">
    <?= Html::submitButton('Seguir', ['class' => 'btn btn-success']) ?>
  </div>
</div>
<?php ActiveForm::end(); ?>
