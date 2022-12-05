<?php

use common\models\Programa;
use dosamigos\tinymce\TinyMce;
use kartik\select2\Select2;
use unclead\multipleinput\MultipleInput;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$isModule = $model->year > 2022;
$js = "$(document).ready(function(){
  $('[data-toggle=\"popover\"]').popover();
});
$(function () {
  $('[data-toggle=\"tooltip\"]').tooltip()
})";
$this->registerJs($js);
if ($isModule){
    $courseTotalHours = $model->asignatura->carga_horaria_cuatr;
    $courseTotalHourWeek = $model->asignatura->carga_horaria_sem;
    $this->registerJs('const courseTotalHourWeek = parseInt(' . $courseTotalHourWeek . ')', \yii\web\View::POS_HEAD);
    $this->registerJs('const maxPercentageByLessonType = ' . json_encode(ArrayHelper::map($lessonTypes,'id', 'max_use_percentage')), \yii\web\View::POS_HEAD);
    $this->registerJsFile('@web/js/timedistribution-create.js',['depends' => [\yii\web\JqueryAsset::class]]);
}
?>
<?= $this->render('_menu_steps', [
  'model' => $model,
  'currentView' => Programa::TIME_DISTRIBUTION_STEP
]) ?>

<h3>Distribución horaria<span  style="font-size:15px"><a href="#" data-toggle="popover" title="Distribución horaria"
    data-content="Según horas semanales establecidas por plan de estudio.">
    <span class="glyphicon glyphicon-question-sign"></span> Ayuda</a></span></h3>

<?php $form = ActiveForm::begin([
'enableAjaxValidation'      => false,
'enableClientValidation'    => false,
'validateOnChange'          => true,
'validateOnSubmit'          => false,
'validateOnBlur'            => false,

]); 

?>

    <small id="js-error" style="color:red;"></small>

    <?php if($error): ?>
        <div><?= $error ?></div>
    <? endif; ?>

    <?php if ($isModule): ?>

    <div id="time-distribution-schema">
    <? foreach($lessonTypes as $lesson): ?>
        <div class="distribution-specification">
            <?=
                $form->field($model, 'modules[time_distribution]['.$lesson->id.'][lesson_type_id]')
                     ->textInput(['maxlength' => true, 'readOnly' => true])
                     ->label(false)->hiddenInput(['value' => $lesson->id])
             ?>
            <div class="col-md-6"> 
            <?=
                $form->field($model, 'modules[time_distribution]['.$lesson->id.'][name]')
                     ->textInput(['maxlength' => true, 'readOnly' => true, 'value' => $lesson->description])
                     ->label(
                         'Modalidad de clase'
                     )
             ?>
            </div> 
            <div class="col-md-4"> 
            <?=
                $form->field($model, 'modules[time_distribution]['.$lesson->id.'][lesson_type_hours]')
                     ->textInput(['maxlength' => true, 'value' => $timeByLessons[$lesson->id] ?? 0, 'class' => ['form-control hours']])
                     ->label(
                         'Horas'
                     )
             ?>
            </div> 
            <div class="col-md-2"> 
            <?=
                $form->field($model, 'modules[time_distribution]['.$lesson->id.'][lesson_type_hours_max_percentage]')
                     ->textInput(['maxlength' => true, 'readOnly' => true, 'class' => ['form-control max_hours']])
                     ->label(
                         'Max <span class="max_percentage">' . $lesson->max_use_percentage . '</span>%'
                     )
             ?>
            </div> 
        </div>
    <? endforeach; ?>
        
    <p> Total de horas usadas <span id="used-hours"></span></p>
    <p> Total de horas disponibles <span id="available-hours"></span></p>
    <small id="course-total-hours"> Horas totales de la asignatura seleccionada <?= $courseTotalHours ?></small>
    </div>
    
    <h3> Observaciones adicionales </h3>
<?php endif; ?>

    <?= $form->field($model, 'distr_horaria')->widget(TinyMce::className(), [
        'options' => ['rows' => 16],
        'language' => 'es',
        'clientOptions' => [
            'plugins' => [
                "advlist autolink lists link charmap preview anchor",
                "searchreplace visualblocks code fullscreen",
                "insertdatetime  table contextmenu paste"
            ],
            'branding' => false,
            'toolbar' => "table | undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link | fullscreen",
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
