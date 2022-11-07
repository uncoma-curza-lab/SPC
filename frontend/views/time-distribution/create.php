<?php

use kartik\select2\Select2;
use unclead\multipleinput\MultipleInput;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
$this->registerJs('const SPC_URL_API = "' . SPC_URL_API . '"',  \yii\web\View::POS_HEAD);
$this->registerJsFile('@web/js/timedistribution-create.js');

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


    <?= $form->field($model, 'lesson_type')->widget(MultipleInput::className(), [
           'min' => 0,
           'max' => 4,
           'columns' => [
               [
                   'name'  => 'leson_type',
                   'title' => 'Tipo de clase',
                   'type' => Select2::class,
                   'options' => [
                       'data' => ArrayHelper::map($lessonTypes,'id','description')
                   ]
               ],
               [
                   'name'  => 'leson_type_hours',
                   'title' => 'Cantidad de horas',
                   'type' => 'textInput',
                   'options' => [
                       'type' => 'number'
                   ]
               ],
           ]
           ])->label(false);
    ?>

    <p> Total de horas usadas <span id="used-hours"></span></p>
    <p> Total de horas disponibles <span id="available-hours"></span></p>

    <div class="form-group text-right">
        <?= Html::submitButton('Guardar', ['id'=> 'anadir-confirmar','class' => 'btn btn-success ']) ?>
    </div>
<?php ActiveForm::end(); ?>
