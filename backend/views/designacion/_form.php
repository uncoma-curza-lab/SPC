<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use common\models\Cargo;
use common\models\Departamento;
use frontend\models\Perfil;

/* @var $this yii\web\View */
/* @var $model backend\models\Designacion */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="designacion-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'cargo_id')->widget(Select2::classname(),[
        'data' => ArrayHelper::map(Cargo::find()->all(),'id','nomenclatura'),
        //'data' =>ArrayHelper::map(((new StatusSearch())->search(['model' => 'backend\models\Status'])),'id','descripcion'),
        //'data' => (new StatusSearch())->search(['model' => 'backend\models\Status'])->id,

        'language' => 'es',
        'options' => ['placeholder' => 'Seleccione una asignatura'],
        'pluginOptions' => [
          'allowClear' => true,
        ],
      ]) ?>
      <?= $form->field($model, 'perfil_id')->widget(Select2::classname(),[
          'data' => ArrayHelper::map(Perfil::find()->all(),'id',function($model){
              return $model->apellido." ".$model->nombre;
          }),
          //'data' =>ArrayHelper::map(((new StatusSearch())->search(['model' => 'backend\models\Status'])),'id','descripcion'),
          //'data' => (new StatusSearch())->search(['model' => 'backend\models\Status'])->id,

          'language' => 'es',
          'options' => ['placeholder' => 'Seleccione una persona'],
          'pluginOptions' => [
            'allowClear' => true,
          ],
        ]) ?>
        <?= $form->field($model, 'departamento_id')->widget(Select2::classname(),[
            'data' => ArrayHelper::map(Departamento::find()->all(),'id','nom'),
            //'data' =>ArrayHelper::map(((new StatusSearch())->search(['model' => 'backend\models\Status'])),'id','descripcion'),
            //'data' => (new StatusSearch())->search(['model' => 'backend\models\Status'])->id,

            'language' => 'es',
            'options' => ['placeholder' => 'Seleccione un depto'],
            'pluginOptions' => [
              'allowClear' => true,
            ],
        ]) ?>
    <?= $form->field($model, 'programa_id')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
