<?php

use kartik\select2\Select2;
use unclead\multipleinput\MultipleInput;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
$this->registerJs('const SPC_URL_API = "' . SPC_URL_API . '"',  \yii\web\View::POS_HEAD);
$this->registerJs('const maxPercentageByLessonType = ' . json_encode(ArrayHelper::map($lessonTypes,'id', 'max_use_percentage')), \yii\web\View::POS_HEAD);
//$this->registerJsFile('@web/js/timedistribution-create.js');
$this->registerJsFile('@web/js/timedistribution-create.js',['depends' => [\yii\web\JqueryAsset::class]]);

?>
    <h2> Distribución horaria </h2>
    <p>(incluye creación del programa de cátedra)</p>
    <hr>

    <?php $form = ActiveForm::begin();  ?>
    <?= $this->render('@frontend/views/mi-programa/forms/_portada', [
          'form' => $form,
          'model' => $model->program,
    ]) ?>
    <small id="spc_api_error" style="color:red;"></small>
    <small id="course-total-hours"></small>


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

        <div class="form-group text-right">
            <?= Html::submitButton('Guardar', ['id'=> 'save-button','class' => 'btn btn-success ']) ?>
        </div>
    </div>
<?php ActiveForm::end(); ?>
