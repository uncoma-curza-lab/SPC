<?php
    $opts = array(
      'http'=>array(
        'method'=>"GET",
        'header'=>"User-Agent: curza api script\r\n"
      )
    );

    $context = stream_context_create($opts);

    $url = "http://web.curza.uncoma.edu.ar/cms/?post_type=materia&#038;p=8732";

    //$file = file_get_contents($url, false, $context);

    $vresponse = json_decode($vdata);
    echo $vresponse;
  /*  $direccion ="materia";
    $json = urlencode($url);
    $datos = json_decode($json,true);
    var_dump($datos);*/

?>
