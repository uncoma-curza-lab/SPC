<?php

use common\models\Programa;
use yii\jui\DatePicker;
use dosamigos\tinymce\TinyMce;
use yii\widgets\ActiveForm;
use yii\helpers\Html;
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
  'currentView' => Programa::ANALYTICAL_CONTENT_STEP
]) ?>

<h3>Contenidos analíticos<span  style="font-size:15px"><a href="#" data-toggle="popover" title="Contenidos analíticos"
    data-content="Según organización del programa en unidades temáticas, núcleos problemáticos, etc.">
    <span class="glyphicon glyphicon-question-sign"></span> Ayuda</a></span></h3>
  <!--<? $this->render('_gridUnidades',['model' => $model]) ?>-->
  <?php $form = ActiveForm::begin([
    'enableAjaxValidation'      => false,
    'enableClientValidation'    => false,
    'validateOnChange'          => true,
    'validateOnSubmit'          => false,
    'validateOnBlur'            => false,
  ]); ?>

  <?= $form->field($model, 'contenido_analitico')->widget(TinyMce::className(), [
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
   <div class="row">
     <div class="col-xs-6 text-left">
       <?= Html::a('Salir sin guardar', ['index'],['onclick'=>"return confirm('No se guardarán los cambios de esta sección, ¿desea salir?')",'class' => 'btn btn-danger']); ?>
       <?= Html::submitButton('Guardar y salir',['class' => 'btn btn-info' , 'name'=>'submit','value' => 'salir']) ?>
     </div>
     <div class="col-xs-6 text-right">
       <?= Html::a('Atrás', ['contenido-plan', 'id' => $model->id],['onclick'=>"return confirm('No se guardarán los cambios de esta sección, ¿desea salir?')",'class' => 'btn btn-warning']) ?>
       <?= Html::submitButton('Siguiente', ['class' => 'btn btn-success']); ?>
     </div>
   </div>
   <?php ActiveForm::end(); ?>
