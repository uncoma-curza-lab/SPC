<?php

use yii\db\Migration;

/**
 * Class m190225_205340_datos
 */
class m190225_205340_datos extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
      $direccion ="materia";
      $url = "http://web.curza.uncoma.edu.ar/cms/wp-json/wp/v2/departamento"."?per_page=100";
      $json = file_get_contents($url);
      $datos = json_decode(utf8_encode($json));
      //todos los departamentos
      foreach ($datos as $key) {
        // todas las carreras
        $carreras = "http://web.curza.uncoma.edu.ar/cms/wp-json/wp/v2/carrera/?departamento=".$key->id."&per_page=100&ordeby=curza_plugin_academico_materia_orden&order=asc";
        $jsoncarr = file_get_contents($carreras);
        $carreras = json_decode(utf8_encode($jsoncarr));


        echo "INSERTANDO DEPARTAMENTO: ". $key->title->rendered."<br>";
        // inserto el departamento y obtengo el ID
        $this->insert('{{%departamento}}', [
            'nom' => $key->title->rendered,
        ]);
        $dptoId = Yii::$app->db->getLastInsertID();
        //Recorro todas las carreras del dpto
        foreach ($carreras as $carrera) {
            //obtengo los planes
            $planes = "http://web.curza.uncoma.edu.ar/cms/wp-json/wp/v2/plan/?carrera=".$carrera->id."&per_page=100&ordeby=curza_plugin_academico_materia_orden&order=asc";
            $jsonplans = file_get_contents($planes);
            $planes = json_decode(utf8_encode($jsonplans));
            //inserto la carrera y obtengo el id de inserción
            $this->insert('{{%carrera}}', [
                'nom' => $carrera->title->rendered,
                'departamento_id' => $dptoId,
            ]);
            $carreraId = Yii::$app->db->getLastInsertID();
            //recorro todos los planes
            foreach ($planes as $plan) {
              //obtengo todas las  materias
              $materias = "http://web.curza.uncoma.edu.ar/cms/wp-json/wp/v2/materia/?plan=".$plan->id."&per_page=100&ordeby=curza_plugin_academico_materia_orden&order=asc";
              $jsonmaterias = file_get_contents($materias);
              $materias = json_decode(utf8_encode($jsonmaterias));
              //inserto el plan y obtengo su id
              $this->insert('{{%plan}}', [
                  'planordenanza' => $plan->title->rendered,
                  'carrera_id' => $carreraId,
              ]);
              $planId = Yii::$app->db->getLastInsertID();
              //recorro todas las materias
              foreach ($materias as $materia) {
                //agrego las materias
                $this->insert('{{%asignatura}}', [
                    'carga_horaria_sem' => $materia->curza_plugin_academico_materia_carga_semanal,
                    'carga_horaria_cuatr' => $materia->curza_plugin_academico_materia_carga_total,
                    'cuatrimestre' => $materia->curza_plugin_academico_materia_dedicacion,
                    'curso' => $materia->curza_plugin_academico_materia_ano,
                    'nomenclatura' => $materia->title->rendered,
                    'plan_id' => $planId,
                    //'departamento_id' => 7,
                ]);
              }
            }
        }
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

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190225_205340_datos cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190225_205340_datos cannot be reverted.\n";

        return false;
    }
    */
}
