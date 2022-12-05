<?php

use common\models\Programa;
use dosamigos\tinymce\TinyMce;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;

$js = "$(document).ready(function(){
  $('[data-toggle=\"popover\"]').popover();
});
$(function () {
  $('[data-toggle=\"tooltip\"]').tooltip()
})";
$this->registerJs($js);
 ?>
    <?= $this->render('_menu_steps', [
      'model' => $model,
      'currentView' => Programa::CREATE_PROGRAM_STEP
    ]) ?>
 <?php $form = ActiveForm::begin([
   'enableAjaxValidation'      => false,
   'enableClientValidation'    => false,
   'validateOnChange'          => true,
   'validateOnSubmit'          => false,
   'validateOnBlur'            => false,
 ]); ?>
  <h3>
    Equipo de cátedra
    <span style="font-size:15px">
      <a href="#"
        id="tourf" data-toggle="popover"
        title="Equipo de cátedra(Opcional)"
        data-content="Si desea, puede ingresar su equipo de cátedra. Luego podrá modificarlo."
        data-placement="right">
        <span class="glyphicon glyphicon-question-sign"></span> Ayuda
      </a>
    </span>
  </h3>

  <?= $form->field($model, 'modules[value]')->widget(TinyMce::className(), [
      'options' => ['rows' => 6, 'value' => $model->equipo_catedra],
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
<br>

<div class="row">
  <div class="col-xs-6 text-left">
    <?= Html::a('Salir sin guardar', ['index'],['onclick'=>"return confirm('No se guardarán los cambios de esta sección, ¿desea salir?')",'class' => 'btn btn-danger']); ?>
    <?= Html::submitButton('Guardar y salir',['class' => 'btn btn-info' , 'name'=>'submit','value' => 'salir']) ?>
  </div>
  <div class="col-xs-6 text-right">
    <?= Html::a('Atrás', ['objetivo-programa', 'id' => $model->id],['onclick'=>"return confirm('No se guardarán los cambios de esta sección, ¿desea salir?')",'class' => 'btn btn-warning']) ?>
    <?= Html::submitButton('Siguiente', ['class' => 'btn btn-success']); ?>
  </div>
</div>
<?php ActiveForm::end(); ?>
