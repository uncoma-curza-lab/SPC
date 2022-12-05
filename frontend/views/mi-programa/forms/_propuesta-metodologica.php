<?php

use common\models\Module;
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
  'currentView' => Module::METHOD_PROPOSAL_TYPE
]) ?>
<h3>Propuesta Metodológica <span  style="font-size:15px"><a href="#" data-toggle="popover" title="Propuesta Metodológica"
    data-content="Señalar la metodología en general y el plan de trabajos prácticos. Se recomienda establecer
una actividad para promover la escritura académica como línea de fortalecimiento institucional de la formación de nuestros estudiantes.">
    <span class="glyphicon glyphicon-question-sign"></span> Ayuda</a></span></h3>
<?php $form = ActiveForm::begin([
  'enableAjaxValidation'      => false,
  'enableClientValidation'    => false,
  'validateOnChange'          => true,
  'validateOnSubmit'          => false,
  'validateOnBlur'            => false,
]); ?>
<?= $form->field($model, 'modules[value]')->widget(TinyMce::className(), [
    'options' => ['rows' => 16, 'value' => $model->propuesta_met],
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
        <?= Html::a('Salir sin guardar', ['index'],['onclick'=>"return confirm('No se guardarán los cambios de esta sección, ¿desea salir?')",'class' => 'btn btn-danger']); ?>
        <?= Html::submitButton('Guardar y salir',['class' => 'btn btn-info' , 'name'=>'submit','value' => 'salir']) ?>
      </div>
      <div class="col-xs-6 text-right">
        <?= Html::a('Atrás', ['bibliografia', 'id' => $model->id],['onclick'=>"return confirm('No se guardarán los cambios de esta sección, ¿desea salir?')",'class' => 'btn btn-warning']) ?>
        <?= Html::submitButton('Siguiente', ['class' => 'btn btn-success']); ?>
      </div>
    </div>
</div>
<?php ActiveForm::end(); ?>
