<?php

use common\models\Asignatura;
use kartik\select2\Select2;
use yii\base\Widget;
use yii\helpers\ArrayHelper;
?>

<?=
    $form->field($model, 'year')
         ->textInput(['maxlength' => true])
         ->label(
             '<span><a href="#" data-toggle="tooltip" title="Año del programa">Año</a></span>'
        )
 ?>

<label for="plan_id">
<span><a href="#"
      data-toggle="tooltip"
      title="Seleccione un plan para obtener la asignatura">Plan</a></span>
</label>
<?= Select2::widget([
    'name' => 'plan_id',
    'language' => 'es',
    'options' => ['placeholder' => 'Seleccione un plan...', 'id' => 'plan_id'],
    'data' => $plans,
    //'initValueText' => $model->parent_id ? $model->parent->nomenclatura : "",
]); ?>

<?= $form->field($model, 'asignatura_id')->widget(Select2::classname(), [
    'language' => 'es',
    'options' => ['placeholder' => 'Seleccione la asignatura que modifica'],
    'pluginOptions' => [
        'allowClear' => true,
        'depends' => ['plan_id'],
        'placeholder' => 'Seleccione un plan...',
        'ajax' => [
            'url' => \yii\helpers\Url::to(['asignatura/get-courses-by-plan-id']),
            'dataType' => 'json',
            'data' => new \yii\web\JsExpression('function(params) {
                return {
                    plan_id: $("#plan_id").val(),
                    q: params.term,
                };
            }'),
            'cache' => true,
        ],

    ],
    //'initValueText' => $model->parent_id ? $model->parent->nomenclatura : "",
])->label('<span><a href="#"
      data-toggle="tooltip"
      title="Asignatura correspondiente al programa">Asignatura</a></span>'); ?>
