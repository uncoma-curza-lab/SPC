<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use common\models\Departamento;
use common\models\Plan;
use dosamigos\tinymce\TinyMce;

?>

<div class="asignatura-form">

    <?php $form = ActiveForm::begin(); ?>
    
    <div class="row">
         <div class="col-md-3">
            <?= $form->field($model, 'nomenclatura')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'departamento_id')->widget(Select2::classname(),[
                'data' => ArrayHelper::map(Departamento::find()->all(),'id','nomenclatura'),
                //'data' =>ArrayHelper::map(((new StatusSearch())->search(['model' => 'backend\models\Status'])),'id','descripcion'),
                //'data' => (new StatusSearch())->search(['model' => 'backend\models\Status'])->id,
                'language' => 'es',
                'options' => ['placeholder' => 'Seleccione un departamento...'],
                'pluginOptions' => [
                  'allowClear' => true,
                ],
            ]) ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'carga_horaria_cuatr')->textInput() ?>
            <?= $form->field($model, 'carga_horaria_sem')->textInput() ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'curso')->textInput() ?>
            <?= $form->field($model, 'cuatrimestre')->textInput() ?>
        </div>
        <div class="col-md-3">
        <?= $form->field($model, 'orden')->input('number') ?>
        </div>
    </div>
    <div class="container">
        <h4>
            Plan o modificatoria
        </h4>
        <div class="col-md-3">
            <?= $form->field($model, 'plan_id')->widget(Select2::classname(),[
                'data' => ArrayHelper::map(Plan::find()->all(),'id',function($model){
                    return $model->ordenanza."(".$model->id.")";
                }),
                'language' => 'es',
                'options' => ['placeholder' => 'Seleccione un plan...'],
                'pluginOptions' => [
                  'allowClear' => true,
                ],
            ]) ?>
        </div>

        <div class="col-md-3">
        <?= $form->field($model, 'parent_id')->widget(Select2::classname(), [
            'language' => 'es',
            'options' => ['placeholder' => 'Seleccione la asignatura que modifica'],
            'pluginOptions' => [
                'allowClear' => true,
                'depends' => ['asignatura-plan_id'],
                'placeholder' => 'Seleccione un plan...',
                'ajax' => [
                    'url' => \yii\helpers\Url::to(['asignatura/get-courses-by-plan-id']),
                    'dataType' => 'json',
                    'data' => new \yii\web\JsExpression('function(params) {
                        return {
                            ' . ($model->id ? "course_id: $model->id," : "") . '
                            plan_id: $("#asignatura-plan_id").val(),
                            q: params.term,
                        };
                    }'),
                    'cache' => true,
                ],

            ],
            'initValueText' => $model->parent_id ? $model->parent->nomenclatura : "",
        ])->label('Asignatura que modifica'); ?>
        </div>
    </div>

    <div class="col-md-12">
        <div class="form-group ">
                <?= $form->field($model, 'requisitos')->widget(TinyMce::className(), [
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
                        'toolbar' => "table | undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link | fullscreen "
                    ]
                ])->label('Requisitos') ?>
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group">
                <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
            </div>
        </div>
    </div>
   

    		   

    		   

      


   

    <?php ActiveForm::end(); ?>

</div>
