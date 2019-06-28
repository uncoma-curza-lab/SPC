<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
  use kartik\select2\Select2;
  use yii\helpers\ArrayHelper;
use common\models\Departamento;
use common\models\Plan;
use common\models\Modalidad;
/* @var $this yii\web\View */
/* @var $model backend\models\Carrera */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="carrera-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'nom')->textInput(['maxlength' => true])->label("Nombre") ?>

    <?= $form->field($model, 'codigo')->textInput() ?>
    <?= $form->field($model, 'duracion_total_anos')->input('float') ?>
    <?= $form->field($model, 'duracion_total_hs')->input('integer') ?>
    <?= $form->field($model, 'alcance')->textInput() ?>
    <?= $form->field($model, 'fundamentacion')->textInput() ?>
    <?= $form->field($model, 'perfil')->textInput() ?>


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
 
    <?php  if ($model->id){
            echo $form->field($model, 'plan_vigente_id')->widget(Select2::classname(),[
              'data' => ArrayHelper::map(Plan::find()->where(['=','carrera_id',$model->id])->all(),'id','planordenanza'),
              //'data' =>ArrayHelper::map(((new StatusSearch())->search(['model' => 'backend\models\Status'])),'id','descripcion'),
              //'data' => (new StatusSearch())->search(['model' => 'backend\models\Status'])->id,
              'language' => 'es',
              'options' => ['placeholder' => 'Seleccione un plan...'],
              'pluginOptions' => [
                'allowClear' => true,
              ],
            ]);
          }  
    ?>
 
    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
