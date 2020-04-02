<?php

/* @var $this yii\web\View */
use \yii\web\View;
$this->title = 'Programas CURZA';
use \yii\bootstrap\Collapse;

$script ='
var tag = document.createElement("script");
tag.src = "https://www.youtube.com/player_api";
var firstScriptTag = document.getElementsByTagName("script")[0];
firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

var player;
function onYouTubePlayerAPIReady() {
  player = new YT.Player("ytplayer", {
    height: "360",
    width: "80%",
    videoId: "nX9PFjBi18s"
  });
  player = new YT.Player("ytplayer2", {
    height: "360",
    width: "80%",
    videoId: "7DsjDnw-b7s"
  });
}';

$this->registerJs($script,View::POS_END);
?>

<div class="site-index">

  <div class="jumbotron">
    <h2 style="font-weight:bold">Ayuda</h2>
  </div>

  <h4>Haga click en los encabezados siguientes en búsqueda de su problema. Se desplegará la ayuda: </h4>
  <?php
  echo Collapse::widget([
    'items' => [
        // equivalent to the above
        [
            'label' => 'Acceso al sistema',
            'content' => '<p><b>No puedo acceder al sistema, no coincide mi cuenta o contraseña.</b></p>
            <p>Por favor, comuniquese conmigo a la siguiente casilla de correo electrónico:</p>
            <p>nestor.murphy (arroba) curza.uncoma.edu.ar</p>',
            'options' => ['class' => 'panel panel-info'],
            // open its content by default
            //'contentOptions' => ['class' => 'in']
        ],
        // another group item
        [
            'label' => 'Videotutorial para profesores',
            'content' => '<p>Si es profesor y necesita cargar sus programas de cátedra, el siguiente videotutorial ayudará a solventar sus dudas.</p>
            <div id="ytplayer"></div>
            <p>Si aún viendo el video sigue teniendo preguntas, escríba al siguiente correo electrónico:</p>
            <p>nestor.murphy (arroba) curza.uncoma.edu.ar</p>',
            'contentOptions' => [],
            //'footer' => 'Footer' // the footer label in list-group
            'options' => ['class' => 'panel panel-info'],
        ],
        [
          'label' => 'Programa de cátedra para varias carreras',
          'content' => '<p>A veces, los programas de cátedra son idénticos para una asignatura "X" dictada en varias carreras. 
          Si usted está buscando cómo cargar este tipo de programa de cátedra, mire el siguiente video.</p>
          <div id="ytplayer2"></div>
          <p>Si aún viendo el video sigue teniendo preguntas, escríba al siguiente correo electrónico:</p>
          <p>nestor.murphy (arroba) curza.uncoma.edu.ar</p>',
          'contentOptions' => [],
          //'footer' => 'Footer' // the footer label in list-group
          'options' => ['class' => 'panel panel-info'],
      ],
        // if you want to swap out .panel-body with .list-group, you may use the following
       
    ]
]);?>

  <p></p>
  <small>Esta sección está en construcción.</small>

</div>
