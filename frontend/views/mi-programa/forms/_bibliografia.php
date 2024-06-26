<?php

use common\models\Module;
use yii\jui\DatePicker;
use dosamigos\tinymce\TinyMce;
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;
?>
<?= $this->render('_menu_steps', [
  'model' => $model,
  'currentView' => Module::BIBLIOGRAPHY_TYPE
]) ?>

<h3>Bibliografía</h3>
  <?php $form = ActiveForm::begin([
    'enableAjaxValidation'      => false,
    'enableClientValidation'    => false,
    'validateOnChange'          => true,
    'validateOnSubmit'          => false,
    'validateOnBlur'            => false,
  ]); ?>
  <?= $form->field($model, 'modules[value]')->widget(TinyMce::className(), [
      'options' => ['rows' => 12, 'value' => $model->biblio_basica],
      'language' => 'es',
      'value' => 'pepe',
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


   <div class="row">
     <div class="col-xs-6 text-left">
       <?= Html::a('Salir sin guardar', ['index'],['onclick'=>"return confirm('No se guardarán los cambios de esta sección, ¿desea salir?')",'class' => 'btn btn-danger']); ?>
       <?= Html::submitButton('Guardar y salir',['class' => 'btn btn-info' , 'name'=>'submit','value' => 'salir']) ?>
     </div>
     <div class="col-xs-6 text-right">
       <?= Html::a('Atrás', ['contenido-analitico', 'id' => $model->id],['onclick'=>"return confirm('No se guardarán los cambios de esta sección, ¿desea salir?')",'class' => 'btn btn-warning']) ?>
       <?= Html::submitButton('Siguiente', ['class' => 'btn btn-success']); ?>
     </div>
   </div>
   <?php ActiveForm::end(); ?>
