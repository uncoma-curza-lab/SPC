<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use common\models\Carrera;

$planId = $model->id ?? null;

?>

<div class="plan-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'planordenanza')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'carrera_id')->widget(Select2::classname(), [
        'data' => ArrayHelper::map(Carrera::find()->all(), 'id', 'nomenclatura'),
        'language' => 'es',
        'options' => ['placeholder' => 'Seleccione una carrera...'],
        'pluginOptions' => [
            'allowClear' => true,
        ],
    ])->label('Carrera'); ?>

    <?= $form->field($model, 'parent_id')->widget(Select2::classname(), [
        'language' => 'es',
        'options' => ['placeholder' => 'Seleccione un plan padre...'],
        'pluginOptions' => [
            'allowClear' => true,
            'depends' => ['plan-carrera_id'],
            'placeholder' => 'Seleccione un plan...',
            'ajax' => [
                'url' => \yii\helpers\Url::to(['plan/get-plans-by-carrera-id']),
                'dataType' => 'json',
                'data' => new \yii\web\JsExpression('function(params) {
                    return {
                        ' . ($planId ? "plan_id: $planId ," : "") . '
                        carrera_id: $("#plan-carrera_id").val(),
                        q: params.term,
                    };
                }'),
                'cache' => true,
            ],
        ],
        'initValueText' => $model->parent_id ? $model->parent->planordenanza : "",
    ])->label('Plan que modifica'); ?>

    <?= $form->field($model, 'activo')->checkbox(); ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
