<?php
  use \yii\helpers\Html;
  use \yii\helpers\HtmlPurifier;
  use common\models\Departamento;
  $asignatura = $model->getAsignatura()->one();
$designaciones = $model->getDesignaciones()->all();
?>
<head>
  <meta charset="utf-8">
  <title>Programa de <?= Html::encode($asignatura->nomenclatura) ?></title>
  <link href="/css/roboto.css" rel="stylesheet">

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
    <p><b>CURSO: </b><?= Html::encode($model->printCurso()); ?></p>
    <p><b>ORDENANZA: </b>
      <?= Html::encode($model->getCompleteOrdinance()); ?>
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
    <?= HtmlPurifier::process($model->equipo_catedra) ?>
    <!--<ul>

    <?php foreach ($designaciones as $d) : ?>
        <li>
          <?php
            $perfil = $d->getPerfil()->one();

          ?>
          <?  isset($perfil) ? $perfil->nombre." ".$perfil->apellido : "N"; ?>
        </li>
    <?php endforeach; ?>
  </ul>-->
    <br>
    <setpagefooter value="off"></setpagefooter>
</body>
</html>
