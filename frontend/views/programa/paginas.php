<?php
  use \yii\helpers\HtmlPurifier;
  $asignatura = $model->getAsignatura()->one();
?>

<h4> 1. FUNDAMENTACIÓN </h4>
<div class="ml-1">
  <?= HtmlPurifier::process($model->fundament) ?>
</div>

<h4> 2. OBJETIVOS SEGÚN PLAN DE ESTUDIOS </h4>
<div class="ml-1">
  <?= HtmlPurifier::process($model->objetivo_plan) ?>
</div>
<div class="ml-2">
  <h5><b> 2.1 OBJETIVOS DEL PROGRAMA </b></h5>
  <?= HtmlPurifier::process($model->objetivo_programa) ?>
</div>


<h4> 3. CONTENIDOS SEGÚN PLAN DE ESTUDIOS </h4>
<div class="ml-1">
  <?= HtmlPurifier::process($model->contenido_plan) ?>
</div>

<h4> 4. CONTENIDOS ANALÍTICOS </h4>
<div class="ml-1">
  <?= HtmlPurifier::process($model->contenido_analitico) ?>
</div>

<h4> 5. BIBLIOGRAFÍA </h4>
<?php if($model->getBibliografiaConsulta()): ?>
  <div class="ml-1">
  <h4> <span style="font-weight:normal">BIBLIOGRAFÍA BÁSICA</span></h4>
  <?= HtmlPurifier::process($model->biblio_basica) ?>
  <h4><span style="font-weight:normal">BIBLIOGRAFÍA DE CONSULTA</span></h4>
  <?= HtmlPurifier::process($model->biblio_consulta) ?>
  </div>
<?php else : ?>
  <div class="ml-1">
    <?= HtmlPurifier::process($model->getBibliografiaBasica()) ?>
  </div>
<?php endif; ?>

<h4> 6. PROPUESTA METODOLÓGICA </h4>
<div class="ml-1">
<?= HtmlPurifier::process($model->propuesta_met) ?>
</div>

<h4> 7. EVALUACIÓN Y CONDICIONES DE ACREDITACIÓN </h4>
<div class="ml-1">
  <?= HtmlPurifier::process($model->evycond_acreditacion) ?>
</div>

<h4> 8. PARCIALES, RECUPERATORIOS Y COLOQUIOS </h4>
<div class="ml-1">
  <?= HtmlPurifier::process($model->parcial_rec_promo) ?>
</div>

<h4> 9. DISTRIBUCIÓN HORARIA </h4>
<div class="ml-1">
<?php 
  if($timesDistributions):
?>
  <table>
    <tr>
      <th>Modalidad</th>
      <th>Minutos *</th>
      <th>Porcentaje</th>
    </tr>
<?php 
    foreach ($timesDistributions as $timeDistribution) :
      $desimalHours = round(($asignatura->carga_horaria_sem * $timeDistribution->percentage_quantity) / 100, 2);
      $minutes = $desimalHours * 60;
?>
    <tr>
      <td>
        <?=  HtmlPurifier::process($timeDistribution->lessonType->description) ?>
      </td>
      <td class="text-center">
        <?=  HtmlPurifier::process($minutes) ?> 
      </td>
      <td class="text-center">
        <?=  HtmlPurifier::process($timeDistribution->percentage_quantity) . '%' ?>
      </td>
    </tr>
<?php 
    endforeach;
?>
  </table>
<p>* Minutos de dictado semanal</p>
<h5>Observaciones</h5>
<?php 
  endif; 
?>
  <?= HtmlPurifier::process($model->distr_horaria) ?>
</div>

<h4> 10. CRONOGRAMA TENTATIVO </h4>
<div class="ml-1">
  <?= HtmlPurifier::process($model->crono_tentativo) ?>
</div>

<h4> 11. PLANIFICACIÓN DE ACTIVIDADES EXTRACURRICULARES </h4>
<div class="ml-1">
  <?= HtmlPurifier::process($model->actv_extracur) ?>
</div>

<div class="container firma" >
    <?= HtmlPurifier::process($model->getFirma()); ?>
</div>

<style>
.ml-1 {
  margin-left: 20px;
}

.ml-2 {
  margin-left: 40px;
}

table {
  width: 90%;
  border: 1px solid;
}

th , td, tr {
  padding: 0.7em;
}

.text-center {
  text-align: center;
}
</style>
