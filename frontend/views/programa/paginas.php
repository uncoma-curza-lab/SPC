<?php
  use \yii\helpers\Html;
  use \yii\helpers\HtmlPurifier;
  use common\models\Departamento;
  $asignatura = $model->getAsignatura()->one();

?>
  <h4> 1. FUNDAMENTACIÓN </h4>
  <?= HtmlPurifier::process($model->fundament) ?>

  <h4> 2. OBJETIVOS SEGÚN PLAN DE ESTUDIOS </h4>
  <?= HtmlPurifier::process($model->objetivo_plan) ?>

  <h4> 3. CONTENIDO SEGÚN PLAN DE ESTUDIOS </h4>
  <?= HtmlPurifier::process($model->contenido_plan) ?>

  <h4> 4. CONTENIDOS ANALÍTICOS </h4>
  <?= HtmlPurifier::process($model->contenido_analitico) ?>
  <!--<?php
    $unidades = $model->getUnidades()->all();
    $cont = 1;
    foreach ($unidades as $key) :
  ?>
    <div style="margin-left:10px;">
      <h4> Unidad <?= $cont ?> </h4>
       <? HtmlPurifier::process($key->descripcion) ?>
    </div>
    <div style="line-height:18px; margin-left:20px;">
      <?php $temas = $key->getTemas()->all(); ?>
      <h4> Temas de la unidad:</h4>
      <?php foreach ($temas as $tmodel) : ?>
        <? HtmlPurifier::process($tmodel->descripcion) ?>
      <?php endforeach; ?>
    </div>
  <?php
    $cont++;
    endforeach;
  ?>-->
  <h4> 5. PROPUESTA METODOLÓGICA </h4>
  <?= HtmlPurifier::process($model->propuesta_met) ?>

  <h4> 6. EVALUACIÓN Y CONDICIONES DE ACREDITACIÓN </h4>
  <?= HtmlPurifier::process($model->evycond_acreditacion) ?>

  <h4> 7. PARCIALES, RECUPERATORIOS Y COLOQUIOS </h4>
  <?= HtmlPurifier::process($model->parcial_rec_promo) ?>

  <h4> 8. DISTRIBUCIÓN HORARIA </h4>
  <?= HtmlPurifier::process($model->distr_horaria) ?>

  <h4> 9. CRONOGRAMA TENTATIVO </h4>
  <?= HtmlPurifier::process($model->crono_tentativo) ?>

  <h4> 10. PLANIFICACIÓN DE ACTIVIDADES EXTRACURRICULARES </h4>
  <?= HtmlPurifier::process($model->actv_extracur) ?>

  <br><br>
  <div class="" style="text-align:center">
    Firma del responsable <br>
    Aclaración <br>
    Cargo <br>
  </div>
  <br><br>
  <div class="" style="text-align:right">
    Lugar y fecha de entrega
  </div>
