<?php

/* @var $this yii\web\View */
use \yii\web\View;
$this->title = 'Programas CURZA';

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
}';
$this->registerJs($script,View::POS_END);
?>

<div class="site-index">

  <div class="jumbotron">
    <h2 style="font-weight:bold">Ayuda</h2>
  </div>

  <h4>Haga click en los encabezados siguientes en búsqueda de su problema. Se desplegará la ayuda: </h4>

  <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
  <div class="panel panel-default">
    <div class="panel-heading" role="tab" id="headingOne">
      <h4 class="panel-title">
        <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
          Acceso al sistema
        </a>
      </h4>
    </div>
    <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
      <div class="panel-body">
        <p><b>No puedo acceder al sistema, no coincide mi cuenta o contraseña.</b></p>
        <p>Por favor, comuniquese conmigo a la siguiente casilla de correo electrónico:</p>
        <p>nestor.murphy (arroba) curza.uncoma.edu.ar</p>
      </div>
    </div>
  </div>
  <div class="panel panel-default">
    <div class="panel-heading" role="tab" id="headingTwo">
      <h4 class="panel-title">
        <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
          Videotutorial para profesores
        </a>
      </h4>
    </div>
    <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
      <div class="panel-body">
        <p>Si es profesor y necesita cargar sus programas de cátedra, el siguiente videotutorial ayudará a solventar sus dudas.</p>
        <div id="ytplayer"></div>
        <p>Si aún viendo el video sigue teniendo preguntas, escríba al siguiente correo electrónico:</p>
        <p>nestor.murphy (arroba) curza.uncoma.edu.ar</p>
      </div>
    </div>
  </div>
  <p></p>
  <small>Esta sección está en construcción.</small>

</div>
