<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use common\models\Asignatura;
use common\models\Plan;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model common\models\correlativa */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="correlativa-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'asignatura_id')->widget(Select2::classname(),[
        'data' => ArrayHelper::map(Asignatura::find()->all(),'id',
        function($model,$e){
          $plan = $model->getPlan()->one();
          $carrera = $plan->getCarrera()->one();
          $dep = $carrera->getDepartamento()->one();
          return isset($dep) ? $model->nomenclatura. ($model->orden ? " ( N°: ".$model->orden. ")" :" (Sin Orden)") : "N";
        },function($model,$e){
          $plan = $model->getPlan()->one();
          
          return isset($plan) ? $plan->planordenanza: null;
        }
        ),
        'language' => 'es',
        'options' => ['placeholder' => 'Seleccione una materia'],
        'pluginOptions' => [
          'allowClear' => true,
        ],
      ]) ?>
      <?= $form->field($model, 'correlativa_id')->widget(Select2::classname(),[
        'data' => ArrayHelper::map(Asignatura::find()->all(),'id',function($model,$e){
          $plan = $model->getPlan()->one();
          $carrera = $plan->getCarrera()->one();
          $dep = $carrera->getDepartamento()->one();
          return isset($dep) ? $model->nomenclatura. ($model->orden ? " ( N°: ".$model->orden. ")" :" (Sin Orden)") : "N";
        },function($model,$e){
          $plan = $model->getPlan()->one();
          return isset($plan) ? $plan->planordenanza: null;
        }),
        'language' => 'es',
        'options' => ['placeholder' => 'Seleccione una materia'],
        'pluginOptions' => [
          'allowClear' => true,
        ],
      ]) ?>
      
 

    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
