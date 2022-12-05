<?php

use common\models\Asignatura;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
?>

<?=
    $form->field($model, 'year')
         ->textInput(['maxlength' => true])
         ->label(
             '<span><a href="#" data-toggle="tooltip" title="Año del programa">Año</a></span>'
        )
 ?>

<?= $form->field($model, 'asignatura_id')->widget(Select2::classname(),[
    'data' => ArrayHelper::map(Asignatura::find()->all(),
                'id',
                function($model, $e) {
                  $plan = $model->getPlan()->one();
                  $carrera = $plan->getCarrera()->one();
                  $dep = $carrera->getDepartamento()->one();
                  return isset($dep) ? $model->nomenclatura." (".$plan->planordenanza.")" : "N";
                },
                function($model, $e) {
                  $plan = $model->getPlan()->one();
                  $carrera = $plan->getCarrera()->one();
                  $dep = $carrera->getDepartamento()->one();
                  return isset($dep) ? $dep->nom : "N";
                }
              ),
    'language' => 'es',
    'options' => ['placeholder' => 'Seleccione una asignatura'],
    'pluginOptions' => [
      'allowClear' => true,
    ],
  ])  ->label('<span><a href="#"
      data-toggle="tooltip"
      title="Asignatura correspondiente al programa">Asignatura</a></span>')
 ?>
