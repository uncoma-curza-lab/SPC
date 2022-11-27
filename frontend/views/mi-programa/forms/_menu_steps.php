<?php

use common\models\Programa;
use yii\helpers\Url;
$mensaje = [ 'onclick'=>"return confirm('No se guardarán los cambios de esta pestaña, ¿desea salir?')"];
$breads = [
    Programa::FUNDAMENTALS_STEP => ['label' => 'Fundamentación','url' => Url::to(['fundamentacion', 'id' => $model->id]), 'options'=>[ 'onclick'=>"return confirm('No se guardarán los cambios de esta pestaña, ¿desea salir?')"]],
    Programa::PLAN_OBJECTIVE_STEP => ['label' => 'Objetivos según plan de estudio', 'url' => Url::to(['objetivo-plan', 'id' => $model->id]), 'options'=> $mensaje],
    Programa::PROGRAM_OBJECTIVE_STEP => ['label' => 'Objetivos del programa', 'url' => Url::to(['objetivo-programa', 'id' => $model->id]), 'options'=> $mensaje],
    Programa::PLAN_CONTENT_STEP => ['label' => 'Contenidos según plan de estudio', 'url' => Url::to(['contenido-plan', 'id' => $model->id]), 'options'=> $mensaje],
    Programa::ANALYTICAL_CONTENT_STEP => ['label' => 'Contenidos analíticos', 'url' => Url::to(['contenido-analitico', 'id' => $model->id]), 'options'=> $mensaje],
    Programa::BIBLIOGRAPHY_STEP => ['label' => 'Bibliografía', 'url' => Url::to(['bibliografia', 'id' => $model->id]), 'options'=> $mensaje],
    Programa::METHOD_PROPOSAL_STEP => ['label' => 'Propuesta Metodológica', 'url' => Url::to(['propuesta-metodologica', 'id' => $model->id]), 'options'=> $mensaje],
    Programa::EVALUATION_AND_ACCREDITATION_STEP => ['label' => 'Evaluación y cond. de acreditación', 'url' => Url::to(['eval-acred', 'id' => $model->id]), 'options'=> $mensaje],
    Programa::EXAMS_AND_PROMOTION_STEP => ['label' => 'Parciales, recuperatorios y promociones', 'url' => Url::to(['parcial-rec-promo', 'id' => $model->id]), 'options'=> $mensaje],
    Programa::TIME_DISTRIBUTION_STEP => ['label' => 'Distribución horaria', 'url' => Url::to(['dist-horaria', 'id' => $model->id]), 'options'=> $mensaje],
    Programa::TIMELINE_STEP => ['label' => 'Cronograma tentativo', 'url' => Url::to(['crono-tentativo', 'id' => $model->id]), 'options'=> $mensaje],
    Programa::ACTIVITIES_STEP => ['label' => 'Actividad extracurricular', 'url' => Url::to(['actividad-extracurricular', 'id' => $model->id]), 'options'=> $mensaje],
    Programa::SIGN_STEP => ['label' => 'Firma','url' => Url::to(['firma', 'id' => $model->id]), 'options'=> $mensaje],
];

foreach ($breads as $key => $step) {
    if ($currentView == $key) {
        unset($step['url']);
    }
    $this->params['items'][] = $step;
}
$this->params['breadcrumbs'][] = ['label' => '...'];
$this->params['breadcrumbs'][] = ['label' => "Evaluacion y acreditación", 'url' => ['eval-acred', 'id' => $model->id]];
$this->params['breadcrumbs'][] = ['label' => "Parciales, recuperatorios y coloquios", 'url' => ['parc-rec-promo', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Distribución Horaria';
$porcentaje = $model->calcularPorcentajeCarga();

?>
<div class="row">
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
