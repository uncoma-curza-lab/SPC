
<?php
  use dosamigos\tinymce\TinyMce;
  use yii\helpers\Html;
  use yii\widgets\ActiveForm;
  use yii\helpers\Url;
  $this->params['breadcrumbs'][] = ['label' => 'Programas', 'url' => ['index']];
  $this->params['breadcrumbs'][] = ['label' =>  $model->getNomenclatura() ];

  $mensaje = [ 'onclick'=>"return confirm('No se guardarán los cambios de esta pestaña, ¿desea salir?')"];
  $this->params['items'][] = ['label' => '1. Fundamentación'];
  $this->params['items'][] = ['label' => '2. Objetivos según plan de estudio', 'url' => Url::to(['objetivo-plan', 'id' => $model->id]), 'options'=> $mensaje];
  $this->params['items'][] = ['label' => '2.1 Objetivos del programa', 'url' => Url::to(['objetivo-programa', 'id' => $model->id]), 'options'=> $mensaje];
  $this->params['items'][] = ['label' => '3. Contenidos según plan de estudio', 'url' => Url::to(['contenido-plan', 'id' => $model->id]), 'options'=> $mensaje];
  $this->params['items'][] = ['label' => '4. Contenidos analíticos', 'url' => Url::to(['contenido-analitico', 'id' => $model->id]), 'options'=> $mensaje];
  $this->params['items'][] = ['label' => '5. Bibliografía', 'url' => Url::to(['bibliografia', 'id' => $model->id]), 'options'=> $mensaje];
  $this->params['items'][] = ['label' => '6. Propuesta Metodológica', 'url' => Url::to(['propuesta-metodologica', 'id' => $model->id]), 'options'=> $mensaje];
  $this->params['items'][] = ['label' => '7. Evaluación y cond. de acreditación', 'url' => Url::to(['eval-acred', 'id' => $model->id]), 'options'=> $mensaje];
  $this->params['items'][] = ['label' => '8. Parciales, recuperatorios y promociones', 'url' => Url::to(['parcial-rec-promo', 'id' => $model->id]), 'options'=> $mensaje];
  $this->params['items'][] = ['label' => '9. Distribución horaria', 'url' => Url::to(['dist-horaria', 'id' => $model->id]), 'options'=> $mensaje];
  $this->params['items'][] = ['label' => '10. Cronograma tentativo', 'url' => Url::to(['crono-tentativo', 'id' => $model->id]), 'options'=> $mensaje];
  $this->params['items'][] = ['label' => '11. Actividad extracurricular', 'url' => Url::to(['actividad-extracurricular', 'id' => $model->id]), 'options'=> $mensaje];
  $this->params['items'][] = ['label' => 'Firma','url' => Url::to(['firma', 'id' => $model->id]), 'options'=> $mensaje];
$this->params['breadcrumbs'][] = 'Fundamentacion';
  $porcentaje = $model->calcularPorcentajeCarga();

  $js = "$(document).ready(function(){
    $('[data-toggle=\"popover\"]').popover();
  });
  $(function () {
    $('[data-toggle=\"tooltip\"]').tooltip()
  })";
  $this->registerJs($js);
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
<h3>1. Fundamentación<span  style="font-size:15px"><a href="#" data-toggle="popover" title="Fundamentación"
    data-content="Ubicación de la asignatura dentro del Plan de estudios. Correlativas anteriores y posteriores. Sentido de la asignatura. Propósitos y estructura del programa.">
    <span class="glyphicon glyphicon-question-sign"></span> Ayuda</a></span></h3>

<?= $form->field($model, 'fundament')->widget(TinyMce::className(), [
    'options' => ['rows' => 16],
    'language' => 'es',
    'clientOptions' => [
        'plugins' => [
            "advlist autolink lists link charmap
            "//print
            ."preview anchor",
            "searchreplace visualblocks code fullscreen",
            "insertdatetime  table contextmenu paste"
        ],
        'branding' => false,
        'toolbar' => "table | undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link | fullscreen ",
        'contextmenu' => "copy  paste | link"
    ]
])->label('') ?>
<br>

<div class="form-group">
  <div class="row">
    <div class="col-xs-6 text-left">
        <?= Html::a('Salir sin guardar', ['index'],['onclick'=>"return confirm('No se guardarán los cambios de esta sección, ¿desea salir?')",'data-toggle'=>"tooltip",
        'title'=>"La sección actual no se guardará", 'class' => 'btn btn-danger']); ?>
        <?= Html::submitButton('Guardar y salir',['data-toggle'=>"tooltip",
        'title'=>"Guarda la sección actual",'class' => 'btn btn-info' , 'name'=>'submit','value' => 'salir']); ?>
    </div>
    <div class="col-xs-6 text-right">
      <?= Html::submitButton('Seguir', ['data-toggle'=>"tooltip",
      'title'=>"Guarda la sección actual",'class' => 'btn btn-success']); ?>
    </div>
  </div>
</div>
<?php ActiveForm::end(); ?>
