<?php
  use yii\helpers\Html;
  use yii\widgets\ActiveForm;
  use kartik\select2\Select2;
  use yii\helpers\ArrayHelper;
  use common\models\Asignatura;
  use dosamigos\tinymce\TinyMce;
  $js = "$(document).ready(function(){
    $('[data-toggle=\"popover\"]').popover();
  });";
  $this->registerJs($js);
?>
<br>
<div class="progress">
  <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="1" aria-valuemin="0" aria-valuemax="100" style="width: 1%">
     1%
  </div>
</div>
<?php $form = ActiveForm::begin(); ?>
<?= $form->field($model, 'year')->textInput(['maxlength' => true]) ?>

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
    //'data' =>ArrayHelper::map(((new StatusSearch())->search(['model' => 'backend\models\Status'])),'id','descripcion'),
    //'data' => (new StatusSearch())->search(['model' => 'backend\models\Status'])->id,

    'language' => 'es',
    'options' => ['placeholder' => 'Seleccione una asignatura'],
    'pluginOptions' => [
      'allowClear' => true,
    ],
  ]) ?>
  <hr>
  <h3>
    Equipo de cátedra
    <span style="font-size:15px">
      <a href="#"
        id="tourf" data-toggle="popover"
        title="Ayuda"
        data-content="Si desea, puede ingresar su equipo de cátedra. Luego podrá editarlo.">
        <span class="glyphicon glyphicon-question-sign"></span> Ayuda
      </a>
    </span>
  </h3>

  <?= $form->field($model, 'equipo_catedra')->widget(TinyMce::className(), [
      'options' => ['rows' => 6],
      'language' => 'es',
      'clientOptions' => [
          'plugins' => [
              "advlist autolink lists link charmap
              "//print
              ."preview anchor",
              "searchreplace visualblocks code fullscreen",
              "insertdatetime  table contextmenu paste"
          ],
          'toolbar' => "undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link | fullscreen "
      ]
  ])->label('') ?>
  <div class="form-group">
      <?= Html::submitButton('Guardar', ['id'=> 'anadir-confirmar','class' => 'btn btn-success']) ?>
  </div>

  <?php ActiveForm::end(); ?>
