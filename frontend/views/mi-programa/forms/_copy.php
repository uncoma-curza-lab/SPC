<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use dosamigos\tinymce\TinyMce;
use yii\helpers\Url;
use kartik\select2\Select2;
use common\models\Asignatura;
use yii\helpers\ArrayHelper;


$this->params['breadcrumbs'][] = ['label' => "Mis programas", 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Copiar un programa';
$this->title = 'Copiar un programa';

$js = "$(document).ready(function(){
  $('[data-toggle=\"popover\"]').popover();
});
$(function () {
  $('[data-toggle=\"tooltip\"]').tooltip()
})";

$this->registerJs($js);
?>
  <h3> 
    Copiar el programa
    <span style="font-size:15px">
      <a href="#"
        id="tourf" data-toggle="popover"
        title="Copiar programa"
        data-content="Usted puede copiar un programa para utilizar el contenido del mismo sobre un plan de carrera diferente"
        data-placement="bottom">
        <span class="glyphicon glyphicon-question-sign"></span> Ayuda
      </a>
    </span>
  </h3>
  <p><b>Programa a copiar: </b><?php 
      // desde el modelo copiado
      $asign = $oldModel->getAsignatura()->one(); 
      $asign ? $plan = $asign->getPlan()->one() : $plan = null;
      $plan ? $plan = $plan->getOrdenanza() : $plan="";
      echo $asign->getNomenclatura()." (".$plan.")" ?>
  </p>
  <hr>
  <?php $form = ActiveForm::begin([
    'enableAjaxValidation'      => false,
    'enableClientValidation'    => false,
    'validateOnChange'          => true,
    'validateOnSubmit'          => false,
    'validateOnBlur'            => false,
  ]); ?>
    
  <?= $form->field($model, 'year')->textInput(['maxlength' => true])
            ->label('<span><a href="#"
              data-toggle="tooltip"
              title="Indique el año del nuevo programa">Año</a></span>') ?>


  <?= $form->field($model, 'asignatura_id')->widget(Select2::classname(),[
      'data' => ArrayHelper::map(Asignatura::find()->all(),
                  'id',
                  function($model,$e){
                    $plan = $model->getPlan()->one();
                    $carrera = $plan->getCarrera()->one();
                    $dep = $carrera->getDepartamento()->one();
                    return isset($dep) ? $model->nomenclatura." (".$plan->planordenanza.")" : "N";
                  },
                  function($model,$e){
                    $plan = $model->getPlan()->one();
                    $carrera = $plan->getCarrera()->one();
                    $dep = $carrera->getDepartamento()->one();
                    return isset($dep) ? $dep->nom : "N";
                  }
                ),

      'language' => 'es',
      'options' => ['placeholder' => 'Seleccione una asignatura destino'],
      'pluginOptions' => [
        'allowClear' => true,
      ],
    ])  ->label('<span><a href="#"
        data-toggle="tooltip"
        title="Indique la asignatura a la que pertenece esta copia">Asignatura destino</a></span>') ?>
  <div class="form-group">
      <div class="row">
        <div class="col-xs-6 text-left">
          <?= Html::a('Salir sin guardar', ['index'],['onclick'=>"return confirm('No se generará la copia destino, ¿desea salir?')",'class' => 'btn btn-danger']); ?>
        </div>
        <div class="col-xs-6 text-right">
          <?= Html::submitButton('Generar copia', ['class' => 'btn btn-success']) ?>
        </div>
      </div>
  </div>
  <?php ActiveForm::end(); ?>
