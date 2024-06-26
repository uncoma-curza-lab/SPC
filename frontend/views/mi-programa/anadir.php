<?php
  use yii\helpers\Html;
  use yii\widgets\ActiveForm;
  use dosamigos\tinymce\TinyMce;
  $js = "$(document).ready(function(){
    $('[data-toggle=\"popover\"]').popover();
  });
  $(function () {
    $('[data-toggle=\"tooltip\"]').tooltip()
  })";

  $this->registerJs($js);
?>
<br>
<div class="row">
  <div class="col-md-9">
    <a href="#"
      data-toggle="tooltip"
      title="Barra de progreso"
    >
      <div class="progress">
        <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="1" aria-valuemin="0" aria-valuemax="100" style="width: 1%">
           1%
        </div>
      </div>
    </a>
  </div>
  <div class="col-md-2 col-md-offset-1 ">
    <span style="font-size:15px">
      <a href="#"
        id="tourf" data-toggle="popover"
        title="Crear un nuevo programa"
        data-content="Los secciones de los programas se irán mostrando a medida que avance. Complete la portada para comenzar."
        data-placement="bottom">
        <span class="glyphicon glyphicon-question-sign"></span> Comenzar
      </a>
    </span>
  </div>
</div>
<h2>Portada</h2>
<?php $form = ActiveForm::begin(); ?>

  <?= $this->render('forms/_portada', [
        'form' => $form,
        'model' => $model,
        'plans' => $plans,
  ]) ?>

  <div class="form-group text-right">
      <?= Html::submitButton('Guardar', ['id'=> 'anadir-confirmar','class' => 'btn btn-success ']) ?>
  </div>

  <?php ActiveForm::end(); ?>
