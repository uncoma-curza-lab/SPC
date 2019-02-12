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
      <h2>UNIVERSIDAD NACIONAL DEL COMAHUE</h2>
      <h3>CENTRO UNIVERSITARIO REGIONAL ZONA ATLANTICA</h3>
    </div>
    <br>
    <!--Departamento de <? //Html::encode(Departamento::find($model->departamento_id)->one()->nom); ?> <br>-->
    <p><b>PROGRAMA DE LA ASIGNATURA:</b> <?= Html::encode($asignatura->nomenclatura) ?> </p>
    <p>CARRERA: </p>
    <p>CURSO: <?= Html::encode($model->curso) ?></p>
    <p>AÑO: <?= Html::encode($model->year) ?> </p>
    <p>CUATRIMESTRE: <?= Html::encode($asignatura->cuatrimestre) ?> </p>
    <p>EQUIPO DE CATEDRA:</p>
    <ul>

    <?php foreach ($designaciones as $d) : ?>
        <li>
          <?php
            $perfil = $d->getUser()->one()->getPerfil()->one();

          ?>
          <?=  isset($perfil) ? $perfil->nombre." ".$perfil->apellido : "N"; ?>
        </li>
    <?php endforeach; ?>
    </ul>
    <br>

</body>
</html>
