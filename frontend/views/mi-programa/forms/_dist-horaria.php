<?php

use common\models\Programa;
use dosamigos\tinymce\TinyMce;
use kartik\select2\Select2;
use unclead\multipleinput\MultipleInput;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
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
  'currentView' => Programa::TIME_DISTRIBUTION_STEP
]) ?>

<h3>9. Distribución horaria<span  style="font-size:15px"><a href="#" data-toggle="popover" title="Distribución horaria"
    data-content="Según horas semanales establecidas por plan de estudio.">
    <span class="glyphicon glyphicon-question-sign"></span> Ayuda</a></span></h3>


<?php $form = ActiveForm::begin([
'enableAjaxValidation'      => false,
'enableClientValidation'    => false,
'validateOnChange'          => true,
'validateOnSubmit'          => false,
'validateOnBlur'            => false,

]); ?>

    <small id="spc_api_error" style="color:red;"></small>
    <small id="course-total-hours"></small>

    <?php if($error): ?>
        <div><?= $error ?></div>
    <? endif; ?>

    <div id="time-distribution-schema">
    <?= $form->field($model, 'lesson_type')->widget(MultipleInput::class, [
           'min' => 0,
           'max' => count($lessonTypes),
           'columns' => [
               [
                   'name'  => 'lesson_type',
                   'title' => 'Tipo de clase',
                   'type' => Select2::class,
                   'options' => [
                       'data' => ArrayHelper::map($lessonTypes, 'id', 'description')
                   ]
               ],
               [
                   'name'  => 'lesson_type_hours',
                   'title' => 'Cantidad de horas',
                   'type' => 'textInput',
                   'options' => [
                       'type' => 'number',
                       'step' => '0.01'
                   ]
               ],
               [
                   'name'  => 'lesson_type_max_percentage',
                   'title' => 'Máximo total',
                   'type' => 'textInput',
                   'options' => [
                       'type' => 'number',
                       'disabled' => true,
                   ]
               ],
           ]
           ])->label(false);
    ?>

    <p> Total de horas usadas <span id="used-hours"></span></p>
    <p> Total de horas disponibles <span id="available-hours"></span></p>
    </div>

    <?= $form->field($model, 'distr_horaria')->widget(TinyMce::className(), [
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
    <?= Html::a('Atrás', ['parcial-rec-promo', 'id' => $model->id],['onclick'=>"return confirm('No se guardarán los cambios de esta sección, ¿desea salir?')",'class' => 'btn btn-warning']) ?>
    <?= Html::submitButton('Siguiente', ['class' => 'btn btn-success']); ?>
  </div>
</div>
<?php ActiveForm::end(); ?>
