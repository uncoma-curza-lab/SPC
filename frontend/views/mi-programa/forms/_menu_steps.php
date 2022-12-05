<?php

use common\models\Module;
use yii\helpers\Url;
$mensaje = [ 'onclick'=>"return confirm('No se guardarán los cambios de esta pestaña, ¿desea salir?')"];
$breads = [
    Module::TIME_DISTRIBUTION_TYPE => ['label' => 'Distribución horaria', 'url' => Url::to(['dist-horaria', 'id' => $model->id]), 'options'=>[ 'onclick'=>"return confirm('No se guardarán los cambios de esta pestaña, ¿desea salir?')"]],
    Module::PROFESSORSHIP_TEAM_TYPE => ['label' => 'Equipo de Catedra','url' => Url::to(['equipo-catedra', 'id' => $model->id]), 'options'=> $mensaje],
    Module::FUNDAMENTALS_TYPE => ['label' => 'Fundamentación','url' => Url::to(['fundamentacion', 'id' => $model->id]), 'options'=> $mensaje],
    Module::PLAN_OBJECTIVE_TYPE => ['label' => 'Objetivos según plan de estudio', 'url' => Url::to(['objetivo-plan', 'id' => $model->id]), 'options'=> $mensaje],
    Module::PROGRAM_OBJECTIVE_TYPE => ['label' => 'Objetivos del programa', 'url' => Url::to(['objetivo-programa', 'id' => $model->id]), 'options'=> $mensaje],
    Module::PLAN_CONTENT_TYPE => ['label' => 'Contenidos según plan de estudio', 'url' => Url::to(['contenido-plan', 'id' => $model->id]), 'options'=> $mensaje],
    Module::ANALYTICAL_CONTENT_TYPE => ['label' => 'Contenidos analíticos', 'url' => Url::to(['contenido-analitico', 'id' => $model->id]), 'options'=> $mensaje],
    Module::BIBLIOGRAPHY_TYPE => ['label' => 'Bibliografía', 'url' => Url::to(['bibliografia', 'id' => $model->id]), 'options'=> $mensaje],
    Module::METHOD_PROPOSAL_TYPE => ['label' => 'Propuesta Metodológica', 'url' => Url::to(['propuesta-metodologica', 'id' => $model->id]), 'options'=> $mensaje],
    Module::EVALUATION_AND_ACCREDITATION_TYPE => ['label' => 'Evaluación y cond. de acreditación', 'url' => Url::to(['eval-acred', 'id' => $model->id]), 'options'=> $mensaje],
    Module::EXAMS_AND_PROMOTION_TYPE => ['label' => 'Parciales, recuperatorios y promociones', 'url' => Url::to(['parcial-rec-promo', 'id' => $model->id]), 'options'=> $mensaje],
    Module::TIMELINE_TYPE => ['label' => 'Cronograma tentativo', 'url' => Url::to(['crono-tentativo', 'id' => $model->id]), 'options'=> $mensaje],
    Module::ACTIVITIES_TYPE => ['label' => 'Actividad extracurricular', 'url' => Url::to(['actividad-extracurricular', 'id' => $model->id]), 'options'=> $mensaje],
    Module::SIGN_TYPE => ['label' => 'Firma','url' => Url::to(['firma', 'id' => $model->id]), 'options'=> $mensaje],
];

foreach ($breads as $key => $step) {
    if ($currentView == $key) {
        unset($step['url']);
    }
    $this->params['items'][] = $step;
}
//$this->params['breadcrumbs'][] = ['label' => '...'];
//$this->params['breadcrumbs'][] = ['label' => "Evaluacion y acreditación", 'url' => ['eval-acred', 'id' => $model->id]];
//$this->params['breadcrumbs'][] = ['label' => "Parciales, recuperatorios y coloquios", 'url' => ['parc-rec-promo', 'id' => $model->id]];
//$this->params['breadcrumbs'][] = 'Distribución Horaria';
$porcentaje = $model->calcularPorcentajeCarga();

?>
<div class="row" style="margin-top:10px">
  <div class="col-md-2 text-right">
    <label>Programa completado: </label>
  </div>
  <div class="col-md-10 ">
    <div class="progress">
      <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="<?= $porcentaje ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?= $porcentaje ?>%">
         <?= $porcentaje ?>%
      </div>
    </div>
  </div>
</div>
