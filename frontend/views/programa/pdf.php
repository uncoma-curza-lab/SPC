<?php
  use \yii\helpers\Html;
  use \yii\helpers\HtmlPurifier;
  use common\models\Departamento;
  $asignatura = $model->getAsignatura()->one();

?>

  <title>Programa de <?= Html::encode($asignatura->nomenclatura) ?></title>
  <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
  <style type="text/css">
    .contenedor{
      font-family: 'Roboto', sans-serif;
      font-size: 16px;
    }
    h1,h2,h3,h4 {
      font-weight: bold;
    }
    .titulo{
      text-align: center;
    }
    .firma{
      margin-top: 20vh;
    }
  </style>

<div class="contenedor">

    <div class="titulo">
      <img src="curza_logo.png" width="20%" alt="">
      <p></p>
      <h2>UNIVERSIDAD NACIONAL DEL COMAHUE</h2>
      <h4>CENTRO UNIVERSITARIO REGIONAL ZONA ATLANTICA</h4>
    </div>
    <br>
    <!--Departamento de <? //Html::encode(Departamento::find($model->departamento_id)->one()->nom); ?> <br>-->
    <p><b>PROGRAMA DE LA ASIGNATURA:</b> <?= Html::encode($asignatura->nomenclatura) ?> </p>
    <p><b>CARRERA: </b><?= Html::encode($asignatura->getPlan()->one()->getCarrera()->one()->nom)?> </p>
    <p><b>CURSO: </b>
      <?= $model->printCurso(); ?>
    </p>
    <p><b>ORDENANZA: </b>
      <?= Html::encode($model->getOrdenanza()); ?>
    </p>
    <p><b>AÑO: </b><?= Html::encode($model->year) ?> </p>
    <p>
      <b>CUATRIMESTRE:</b>
      <?php if ($asignatura->cuatrimestre == 1) {
            echo "1°";
          } else if($asignatura->cuatrimestre == 2){
            echo "2°";
          }
      ?>
    </p>
    <p><b>EQUIPO DE CATEDRA:</b></p>
    <div style="margin-left:20px;">
      <?= HtmlPurifier::process($model->equipo_catedra) ?>
    </div>
    <br>
    <div class="container">
      <h4> 1. FUNDAMENTACIÓN </h4>
      <div style="margin-left:20px;">
        <?= HtmlPurifier::process($model->fundament) ?>
      </div>
    </div>
    <div class="container">
      <h4> 2. OBJETIVOS SEGÚN PLAN DE ESTUDIOS </h4>
      <div style="margin-left:20px">
        <?= HtmlPurifier::process($model->objetivo_plan) ?>
      </div>
      <div style="margin-left:40px">
        <h5><b> 2.1 OBJETIVOS DEL PROGRAMA </b></h5>
        <?= HtmlPurifier::process($model->objetivo_programa) ?>
      </div>
    </div>

    <div class="container">
      <h4> 3. CONTENIDOS SEGÚN PLAN DE ESTUDIOS </h4>
      <div style="margin-left:20px;">
        <?= HtmlPurifier::process($model->contenido_plan) ?>
      </div>
    </div>

    <div class="container">
      <h4> 4. CONTENIDOS ANALÍTICOS </h4>
      <div style="margin-left:20px;">
        <?= HtmlPurifier::process($model->contenido_analitico) ?>
      </div>
    </div>
    <div class="container">
      <h4> 5. BIBLIOGRAFÍA </h4>
      <?php if($model->getBibliografiaConsulta()): ?>

        <div style="margin-left:20px;">
          <h4> <span style="font-weight:normal">BIBLIOGRAFÍA BÁSICA</span></h4>
          <?= HtmlPurifier::process($model->getBibliografiaBasica()) ?>
          <h4><span style="font-weight:normal">BIBLIOGRAFÍA DE CONSULTA</span></h4>
          <?= HtmlPurifier::process($model->biblio_consulta) ?>
        </div>
      <?php else: ?>
        <div style="margin-left:20px;">
          <?= HtmlPurifier::process($model->getBibliografiaBasica()) ?>
        </div>
      <?php endif; ?>
    </div>
    <div class="container">
      <h4> 6. PROPUESTA METODOLÓGICA </h4>
      <div style="margin-left:20px;">
      <?= HtmlPurifier::process($model->propuesta_met) ?>
      </div>
    </div>

    <div class="container">
      <h4> 7. EVALUACIÓN Y CONDICIONES DE ACREDITACIÓN </h4>
      <div style="margin-left:20px;">
        <?= HtmlPurifier::process($model->evycond_acreditacion) ?>
      </div>
    </div>

    <div class="container">
      <h4> 8. PARCIALES, RECUPERATORIOS Y COLOQUIOS </h4>
      <div style="margin-left:20px;">
        <?= HtmlPurifier::process($model->parcial_rec_promo) ?>
      </div>
    </div>

    <div class="container">
      <h4> 9. DISTRIBUCIÓN HORARIA </h4>
      <div style="margin-left:20px;">
<?php 
  if($timesDistributions):
?>
  <table>
    <tr>
      <th>Modalidad</th>
      <th class="text-center">Minutos *</th>
      <th class="text-center">Porcentaje</th>
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
    </div>

    <div class="container">
      <h4> 10. CRONOGRAMA TENTATIVO </h4>
      <div style="margin-left:20px;">
        <?= HtmlPurifier::process($model->crono_tentativo) ?>
      </div>
    </div>

    <div class="container">
      <h4> 11. PLANIFICACIÓN DE ACTIVIDADES EXTRACURRICULARES </h4>
      <div style="margin-left:20px;">
        <?= HtmlPurifier::process($model->actv_extracur) ?>
      </div>
    </div>


    <div class="container firma" >
      <?= HtmlPurifier::process($model->getFirma()); ?>
    </div>

</div>
<style>
table {
  width: 80%;
  border: 1px solid;
}

th , td, tr {
  padding: 0.7em;
}

.text-center {
  text-align: center;
}

