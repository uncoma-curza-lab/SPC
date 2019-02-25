<?php

/*

$this->createTable('{{carrera}}',[
  'id'      =>  $this->primaryKey(),
  'nom'     => $this->string()->notNull(),
  'codigo'  => $this->integer(),
  'departamento_id' => $this->integer(),
], $options);
$this->createTable('{{%plan}}',[
  'id'      =>  $this->primaryKey(),
  'planordenanza'   =>  $this->string()->notNull(),
  'carrera_id' => $this->integer(),
], $options);
$this->createTable('{{%asignatura}}',[
  'id'      =>  $this->primaryKey(),
  'orden' => $this->integer(),
  'nomenclatura'   =>  $this->string()->notNull(),
  'curso'   =>  $this->integer()->notNull(),
  'cuatrimestre'   =>  $this->integer()->notNull(),
  'carga_horaria_sem' => $this->integer(),
  'carga_horaria_cuatr'=> $this->integer(),
  'plan_id' => $this->integer(),
  'departamento_id' => $this->integer(),
], $options);

*/


  /*  public function procesarPlan($url){
      $json = file_get_contents($url);
      $datos = json_decode(utf8_encode($json));
      if (strpos($key->_links->{"wp:term"}[0]->href,'categories?post=') !== false){
        $departamento[] = [
          'id' => $key->id,
          'nom' => $key->title->rendered,
        ];
        return $departamento;
      } else {
        if ($key->type == "carrera"){
          $objeto = [
            'id' => $key->id,
            'nom' => $key->title->rendered,
          ];
        } else if( $key->type == "plan" ){
          $objeto = [
            'id' => $key->id,
            'planordenanza' => $key->title->rendered,
          ];
        }else if ($key->type == "materia"){
          $objeto = [
            'id' => $key->id,
            'nomenclatura' => $key->title->rendered,
            'orden' => $key->curza_plugin_academico_materia_orden,
            'carga_horaria_cuatr' =>  $key->$key->curza_plugin_academico_materia_carga_total,
            'carga_horaria_sem' => $key->curza_plugin_academico_materia_carga_semanal,
            'curso' => $key->curza_plugin_academico_materia_ano
          ];
        }
        $url =$key->_links->{"wp:term"}[0]->href;
        procesarPlan($url,$objeto);
      }

    }*/



    $direccion ="materia";
    $url = "http://web.curza.uncoma.edu.ar/cms/wp-json/wp/v2/departamento"."?per_page=100";
    $json = file_get_contents($url);

    $datos = json_decode(utf8_encode($json));
    $todos = [];
    $aDeptos = [];
    foreach ($datos as $key) {
      //echo $key->title->rendered."<br>";
      $carreras = "http://web.curza.uncoma.edu.ar/cms/wp-json/wp/v2/carrera/?departamento=".$key->id."&ordeby=curza_plugin_academico_materia_orden&order=asc";
      $jsoncarr = file_get_contents($carreras);
      $carreras = json_decode(utf8_encode($jsoncarr));

      $aCarr = [];
      foreach ($carreras as $carrera) {
          $planes = "http://web.curza.uncoma.edu.ar/cms/wp-json/wp/v2/plan/?carrera=".$carrera->id."&ordeby=curza_plugin_academico_materia_orden&order=asc";
          $jsonplans = file_get_contents($planes);
          $planes = json_decode(utf8_encode($jsonplans));

          $aPlans = [];
          foreach ($planes as $plan) {
            $materias = "http://web.curza.uncoma.edu.ar/cms/wp-json/wp/v2/materia/?plan=".$plan->id."&ordeby=curza_plugin_academico_materia_orden&order=asc";
            $jsonmaterias = file_get_contents($materias);
            $materias = json_decode(utf8_encode($jsonmaterias));

            $aMat = [];
            foreach ($materias as $materia) {
        //      echo $carrera->title->rendered." ".$materia->title->rendered."<br>";
                $aMat[] = [
                    'nom' => $key->title->rendered,
                ];
            }
            $plan[]=[
                'materias' => $aMat,
                'nombre' => $key->title->rendered,
            ];

          }
          $aCarr[] = [
            'nom' => $key->title->rendered,
            'planes' => $plan
          ];
      }
      $aDeptos[] = [
        'nom' => $key->title->rendered,
        'carreras' => $aCarr
      ];
      //var_dump();
      //  $plan =$key->_links->{"wp:term"}[0]->href;
      //    procesar($plan);
  /*    $asignatura = [];
      $asignatura[] = [
          'nomenclatura' => $key->title->rendered,
          'orden' => $key->curza_plugin_academico_materia_orden,
          'carga_horaria_cuatr' =>  $key->$key->curza_plugin_academico_materia_carga_total,
          'carga_horaria_sem' => $key->curza_plugin_academico_materia_carga_semanal,
          'curso' => $key->curza_plugin_academico_materia_ano
      ];*/

    }
?>
