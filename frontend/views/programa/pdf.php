<?php
  use \yii\helpers\Html;
  use \yii\helpers\HtmlPurifier;
  use common\models\Departamento;
  $asignatura = $model->getAsignatura()->one();

?>
<head>
  <meta charset="utf-8">
  <title>Programa de <?= Html::encode($asignatura->nomenclatura) ?></title>
  <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">

  <style type="text/css">
    body{
      font-family: 'Roboto', sans-serif;
    }
    .titulo{
      text-align: center;
    }
  </style>
</head>
<body>
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
    <p><b>CURSO: </b><?= Html::encode($model->curso) ?></p>
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
    <?= HtmlPurifier::process($model->equipo_catedra) ?>

    <br>
    <h4> 1. FUNDAMENTACIÓN </h4>
    <?= HtmlPurifier::process($model->fundament) ?>

    <h4> 2. OBJETIVOS SEGÚN PLAN DE ESTUDIOS </h4>
    <?= HtmlPurifier::process($model->objetivo_plan) ?>

    <h4> 3. CONTENIDO SEGÚN PLAN DE ESTUDIOS </h4>
    <?= HtmlPurifier::process($model->contenido_plan) ?>

    <h4> 4. CONTENIDOS ANALÍTICOS </h4>
    <?= HtmlPurifier::process($model->contenido_analitico) ?>

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


</body>
</html>
