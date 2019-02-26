<?php

use yii\db\Migration;

/**
 * Class m180906_125930_asignatura
 */
class m180906_125930_asignatura extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
      $options = null;
      if ( $this->db->driverName=='mysql' ) {
        $options = 'CHARACTER SET utf8 COLLATE utf8_spanish_ci ENGINE=innodb';
      }
      $this->createTable('{{%asignatura}}',[
        'id'      =>  $this->primaryKey(),
        'orden' => $this->integer(),
        'nomenclatura'   =>  $this->string()->notNull(),
        'curso'   =>  $this->integer(),
        'cuatrimestre'   =>  $this->integer(),
        'carga_horaria_sem' => $this->integer(),
        'carga_horaria_cuatr'=> $this->integer(),
        'plan_id' => $this->integer(),
        'departamento_id' => $this->integer(),
      ], $options);
      $this->addForeignKey(
        'planasignatura',
        'asignatura',
        'plan_id',
        'plan',
        'id',
        'no action',
        'no action'
      );
      $this->addForeignKey(
        'departamentoasignatura',
        'asignatura',
        'departamento_id',
        'departamento',
        'id',
        'no action',
        'no action'
      );
      /*
      * Psicopedagogía
      */
      $this->insert('{{%asignatura}}', [
          'id' => 1,
          'carga_horaria_sem' => -1,
          'carga_horaria_cuatr' => -1,
          'cuatrimestre' => 1,
          'curso' => 1,
          'departamento_id' => 7,
          'nomenclatura' => 'Introducción a las Ciencias Aplicadas',
          'plan_id' => 14,           'departamento_id' => 7,

      ]);
      $this->insert('{{%asignatura}}', [
          'id' => 2,
          'carga_horaria_sem' => -1,
          'carga_horaria_cuatr' => -1,
          'cuatrimestre' => 1,
          'curso' => 1,
          'nomenclatura' => 'Introducción al Cuidado de la Salud',
          'plan_id' => 14,           'departamento_id' => 7,

      ]);
      $this->insert('{{%asignatura}}', [
          'id' => 3,
          'carga_horaria_sem' => -1,
          'carga_horaria_cuatr' => -1,
          'cuatrimestre' => 0, //anual
          'curso' => 1,
          'nomenclatura' => 'Morfofisiología Aplicada',
          'plan_id' => 14,           'departamento_id' => 7,

      ]);
      $this->insert('{{%asignatura}}', [
          'id' => 4,
          'carga_horaria_sem' => -1,
          'carga_horaria_cuatr' => -1,
          'cuatrimestre' => 1,
          'curso' => 1,
          'nomenclatura' => 'Psicología General y Evolutiva',
          'plan_id' => 14,           'departamento_id' => 7,

      ]);
      $this->insert('{{%asignatura}}', [
          'id' => 5,
          'carga_horaria_sem' => -1,
          'carga_horaria_cuatr' => -1,
          'cuatrimestre' => 1,
          'curso' => 1,
          'nomenclatura' => 'Aspectos Antropológicos del Cuidado',
          'plan_id' => 14,           'departamento_id' => 7,

      ]);
      $this->insert('{{%asignatura}}', [
          'id' => 6,
          'carga_horaria_sem' => -1,
          'carga_horaria_cuatr' => -1,
          'cuatrimestre' => 2,
          'curso' => 1,
          'nomenclatura' => 'Fundamentos de Enfermería',
          'plan_id' => 14,           'departamento_id' => 7,

      ]);
      $this->insert('{{%asignatura}}', [
          'id' => 7,
          'carga_horaria_sem' => -1,
          'carga_horaria_cuatr' => -1,
          'cuatrimestre' => 2,
          'curso' => 1,
          'nomenclatura' => 'Física y Química Biológica Aplicada',
          'plan_id' => 14,           'departamento_id' => 7,

      ]);
      $this->insert('{{%asignatura}}', [
          'id' => 8,
          'carga_horaria_sem' => -1,
          'carga_horaria_cuatr' => -1,
          'cuatrimestre' => 2,
          'curso' => 1,
          'nomenclatura' => 'Microbiología y Parasitología',
          'plan_id' => 14,           'departamento_id' => 7,

      ]);
      /* Segund año Lic enf*/
      $this->insert('{{%asignatura}}', [
          'id' => 9,
          'carga_horaria_sem' => -1,
          'carga_horaria_cuatr' => -1,
          'cuatrimestre' => 0,
          'curso' => 2,
          'nomenclatura' => 'Cuidados Enfermeros de Salud Psicosocial',
          'plan_id' => 14,           'departamento_id' => 7,

      ]);
      $this->insert('{{%asignatura}}', [
          'id' => 10,
          'carga_horaria_sem' => -1,
          'carga_horaria_cuatr' => -1,
          'cuatrimestre' => 1,
          'curso' => 2,
          'nomenclatura' => 'Farmacología I',
          'plan_id' => 14,           'departamento_id' => 7,

      ]);
      $this->insert('{{%asignatura}}', [
          'id' => 11,
          'carga_horaria_sem' => -1,
          'carga_horaria_cuatr' => -1,
          'cuatrimestre' => 1,
          'curso' => 2,
          'nomenclatura' => 'Nutrición y Dietoterapia',
          'plan_id' => 14,           'departamento_id' => 7,

      ]);
      $this->insert('{{%asignatura}}', [
          'id' => 12,
          'carga_horaria_sem' => -1,
          'carga_horaria_cuatr' => -1,
          'cuatrimestre' => 0, // anual
          'curso' => 2,
          'nomenclatura' => 'Cuidados del Adulto y del Anciano',
          'plan_id' => 14,           'departamento_id' => 7,

      ]);
      /*2do cuatrimestre Lic. Enf.*/
      $this->insert('{{%asignatura}}', [
          'id' => 13,
          'carga_horaria_sem' => -1,
          'carga_horaria_cuatr' => -1,
          'cuatrimestre' => 2,
          'curso' => 2,
          'nomenclatura' => 'Aspectos Bioéticos y Legales del Cuidado Enfermero',
          'plan_id' => 14,           'departamento_id' => 7,

      ]);
      $this->insert('{{%asignatura}}', [
          'id' => 14,
          'carga_horaria_sem' => -1,
          'carga_horaria_cuatr' => -1,
          'cuatrimestre' => 2,
          'curso' => 2,
          'nomenclatura' => 'Psicología Social y de las Org.',
          'plan_id' => 14,           'departamento_id' => 7,

      ]);
      $this->insert('{{%asignatura}}', [
          'id' => 15,
          'carga_horaria_sem' => -1,
          'carga_horaria_cuatr' => -1,
          'cuatrimestre' => 2,
          'curso' => 2,
          'nomenclatura' => 'Farmacología II',
          'plan_id' => 14,           'departamento_id' => 7,

      ]);
      /* Tercer año Lic. Enf */
      $this->insert('{{%asignatura}}', [
          'id' => 16,
          'carga_horaria_sem' => -1,
          'carga_horaria_cuatr' => -1,
          'cuatrimestre' => 1,
          'curso' => 3,
          'nomenclatura' => 'Cuidados de la Salud de la Mujer',
          'plan_id' => 14,           'departamento_id' => 7,

      ]);
      $this->insert('{{%asignatura}}', [
          'id' => 17,
          'carga_horaria_sem' => -1,
          'carga_horaria_cuatr' => -1,
          'cuatrimestre' => 1,
          'curso' => 3,
          'nomenclatura' => 'Bioestadística y Epidemiología Aplicada',
          'plan_id' => 14,           'departamento_id' => 7,

      ]);
      $this->insert('{{%asignatura}}', [
          'id' => 18,
          'carga_horaria_sem' => -1,
          'carga_horaria_cuatr' => -1,
          'cuatrimestre' => 1,
          'curso' => 3,
          'nomenclatura' => 'Aspectos Sociológicos del Cuidado',
          'plan_id' => 14,           'departamento_id' => 7,

      ]);
      $this->insert('{{%asignatura}}', [
          'id' => 19,
          'carga_horaria_sem' => -1,
          'carga_horaria_cuatr' => -1,
          'cuatrimestre' => 0,
          'curso' => 3,
          'nomenclatura' => 'Inglés',
          'plan_id' => 14,           'departamento_id' => 7,

      ]);
      /* Segundo Cuatrimestre Lic.Enf año 3 */
      $this->insert('{{%asignatura}}', [
          'id' => 20,
          'carga_horaria_sem' => -1,
          'carga_horaria_cuatr' => -1,
          'cuatrimestre' => 2,
          'curso' => 3,
          'nomenclatura' => 'Cuidados para la Salud Comunitaria I',
          'plan_id' => 14,           'departamento_id' => 7,

      ]);
      $this->insert('{{%asignatura}}', [
          'id' => 21,
          'carga_horaria_sem' => -1,
          'carga_horaria_cuatr' => -1,
          'cuatrimestre' => 2,
          'curso' => 3,
          'nomenclatura' => 'Cuidados de la Salud de Niños y Adolescentes',
          'plan_id' => 14,           'departamento_id' => 7,

      ]);
      $this->insert('{{%asignatura}}', [
          'id' => 22,
          'carga_horaria_sem' => -1,
          'carga_horaria_cuatr' => -1,
          'cuatrimestre' => 2,
          'curso' => 3,
          'nomenclatura' => 'Fundamentos de Investigación en Enfermería',
          'plan_id' => 14,           'departamento_id' => 7,

      ]);
      $this->insert('{{%asignatura}}', [
          'id' => 23,
          'carga_horaria_sem' => -1,
          'carga_horaria_cuatr' => -1,
          'cuatrimestre' => 2,
          'curso' => 3,
          'nomenclatura' => 'Práctica Integradora de Cuidados Enfermeros I',
          'plan_id' => 14,           'departamento_id' => 7,

      ]);
      /* cuarto año Lic. enf */
      $this->insert('{{%asignatura}}', [
          'id' => 24,
          'carga_horaria_sem' => -1,
          'carga_horaria_cuatr' => -1,
          'cuatrimestre' => 1,
          'curso' => 4,
          'nomenclatura' => 'Seminario: La Disciplina Enfermera',
          'plan_id' => 14,           'departamento_id' => 7,

      ]);
      $this->insert('{{%asignatura}}', [
          'id' => 25,
          'carga_horaria_sem' => -1,
          'carga_horaria_cuatr' => -1,
          'cuatrimestre' => 0,
          'curso' => 4,
          'nomenclatura' => 'Metodología de la Investigación en el Cuidado Enfermero',
          'plan_id' => 14,           'departamento_id' => 7,

      ]);
      $this->insert('{{%asignatura}}', [
          'id' => 26,
          'carga_horaria_sem' => -1,
          'carga_horaria_cuatr' => -1,
          'cuatrimestre' => 0,
          'curso' => 4,
          'nomenclatura' => 'Cuidados a Personas en Alto Riesgo de Salud',
          'plan_id' => 14,           'departamento_id' => 7,

      ]);
      $this->insert('{{%asignatura}}', [
          'id' => 27,
          'carga_horaria_sem' => -1,
          'carga_horaria_cuatr' => -1,
          'cuatrimestre' => 1,
          'curso' => 4,
          'nomenclatura' => 'Bioestadística Aplicada',
          'plan_id' => 14,           'departamento_id' => 7,

      ]);
      /* Lic. Enf. Cuato Año 2do cuat */
      $this->insert('{{%asignatura}}', [
          'id' => 28,
          'carga_horaria_sem' => -1,
          'carga_horaria_cuatr' => -1,
          'cuatrimestre' => 2,
          'curso' => 4,
          'nomenclatura' => 'Formación en Enfermería',
          'plan_id' => 14,           'departamento_id' => 7,

      ]);
      $this->insert('{{%asignatura}}', [
          'id' => 29,
          'carga_horaria_sem' => -1,
          'carga_horaria_cuatr' => -1,
          'cuatrimestre' => 2,
          'curso' => 4,
          'nomenclatura' => 'Seminario',
          'plan_id' => 14,           'departamento_id' => 7,

      ]);
      /*Quinto año Lic. Enf */
      $this->insert('{{%asignatura}}', [
          'id' => 30,
          'carga_horaria_sem' => -1,
          'carga_horaria_cuatr' => -1,
          'cuatrimestre' => 0,
          'curso' => 5,
          'nomenclatura' => 'Administracion en Enfermería',
          'plan_id' => 14,           'departamento_id' => 7,

      ]);
      $this->insert('{{%asignatura}}', [
          'id' => 31,
          'carga_horaria_sem' => -1,
          'carga_horaria_cuatr' => -1,
          'cuatrimestre' => 1,
          'curso' => 5,
          'nomenclatura' => 'Cuidados para la Salud Comunitaria II',
          'plan_id' => 14,           'departamento_id' => 7,

      ]);
      $this->insert('{{%asignatura}}', [
          'id' => 32,
          'carga_horaria_sem' => -1,
          'carga_horaria_cuatr' => -1,
          'cuatrimestre' => 1,
          'curso' => 5,
          'nomenclatura' => 'Práctica Integradora de Cuidados Enfermeros II',
          'plan_id' => 14,           'departamento_id' => 7,

      ]);
      $this->insert('{{%asignatura}}', [
          'id' => 33,
          'carga_horaria_sem' => -1,
          'carga_horaria_cuatr' => -1,
          'cuatrimestre' => 1,
          'curso' => 5,
          'nomenclatura' => 'Tesis',
          'plan_id' => 14,           'departamento_id' => 7,

      ]);

      /* Tec Administracion de Sistemas y Soft Libre */
      /* Primer Año */
      $this->insert('{{%asignatura}}', [
          'id' => 34,
          'carga_horaria_sem' => 8,
          'carga_horaria_cuatr' => 128,
          'cuatrimestre' => 1,
          'curso' => 1,
          'nomenclatura' => 'Introducción a la Computación',
          'plan_id' => 1,
          'departamento_id' => 1,
      ]);
      $this->insert('{{%asignatura}}', [
          'id' => 35,
          'carga_horaria_sem' => 8,
          'carga_horaria_cuatr' => 128,
          'cuatrimestre' => 1,
          'curso' => 1,
          'nomenclatura' => 'Matemática General',
          'plan_id' => 1,
          'departamento_id' => 1,
      ]);
      $this->insert('{{%asignatura}}', [
          'id' => 36,
          'carga_horaria_sem' => 4,
          'carga_horaria_cuatr' => 64,
          'cuatrimestre' => 1,
          'curso' => 1,
          'nomenclatura' => 'Inglés Técnico',
          'plan_id' => 1,
          'departamento_id' => 1,
      ]);
      /* Tec. Admin Sist. y Soft. 1° año 2do cuat */
      $this->insert('{{%asignatura}}', [
          'id' => 37,
          'carga_horaria_sem' => 8,
          'carga_horaria_cuatr' => 128,
          'cuatrimestre' => 2,
          'curso' => 1,
          'nomenclatura' => 'Introducción a la programación',
          'plan_id' => 1,
          'departamento_id' => 1,
      ]);
      $this->insert('{{%asignatura}}', [
          'id' => 38,
          'carga_horaria_sem' => 4,
          'carga_horaria_cuatr' => 64,
          'cuatrimestre' => 2,
          'curso' => 1,
          'nomenclatura' => 'Introducción a la Administración de Sistemas',
          'plan_id' => 1,
          'departamento_id' => 1,
      ]);
      $this->insert('{{%asignatura}}', [
          'id' => 39,
          'carga_horaria_sem' => 8,
          'carga_horaria_cuatr' => 128,
          'cuatrimestre' => 2,
          'curso' => 1,
          'nomenclatura' => 'Redes de datos',
          'plan_id' => 1,
          'departamento_id' => 1,
      ]);
      /* Tec. Admin. Soft. Segundo Año*/
      $this->insert('{{%asignatura}}', [
          'id' => 40,
          'carga_horaria_sem' => 4,
          'carga_horaria_cuatr' => 64,
          'cuatrimestre' => 1,
          'curso' => 2,
          'nomenclatura' => 'Software Libre',
          'plan_id' => 1,
          'departamento_id' => 1,
      ]);
      $this->insert('{{%asignatura}}', [
          'id' => 41,
          'carga_horaria_sem' => 8,
          'carga_horaria_cuatr' => 128,
          'cuatrimestre' => 1,
          'curso' => 2,
          'nomenclatura' => 'Taller de Hardware y Software',
          'plan_id' => 1,
          'departamento_id' => 1,
      ]);
      $this->insert('{{%asignatura}}', [
          'id' => 42,
          'carga_horaria_sem' => 8,
          'carga_horaria_cuatr' => 128,
          'cuatrimestre' => 1,
          'curso' => 2,
          'nomenclatura' => 'Administración de Sistemas',
          'plan_id' => 1,
          'departamento_id' => 1,
      ]);
      /* Año 2: 2° Cuatrimestre TUASSYL */
      $this->insert('{{%asignatura}}', [
          'id' => 43,
          'carga_horaria_sem' => 8,
          'carga_horaria_cuatr' => 128,
          'cuatrimestre' => 2,
          'curso' => 2,
          'nomenclatura' => 'Administración de servicios',
          'plan_id' => 1,
          'departamento_id' => 1,
      ]);
      $this->insert('{{%asignatura}}', [
          'id' => 44,
          'carga_horaria_sem' => 8,
          'carga_horaria_cuatr' => 128,
          'cuatrimestre' => 2,
          'curso' => 2,
          'nomenclatura' => 'Sistemas de información',
          'plan_id' => 1,
          'departamento_id' => 1,
      ]);
      $this->insert('{{%asignatura}}', [
          'id' => 45,
          'carga_horaria_sem' => 4,
          'carga_horaria_cuatr' => 64,
          'cuatrimestre' => 2,
          'curso' => 2,
          'nomenclatura' => 'Automatización y Scripting',
          'plan_id' => 1,
          'departamento_id' => 1,
      ]);
      /*TUASYL 3er año 1° cuatrimestre*/
      $this->insert('{{%asignatura}}', [
          'id' => 46,
          'carga_horaria_sem' => 8,
          'carga_horaria_cuatr' => 128,
          'cuatrimestre' => 1,
          'curso' => 3,
          'nomenclatura' => 'Administración de sistemas Avanzada',
          'plan_id' => 1,
          'departamento_id' => 1,
      ]);
      $this->insert('{{%asignatura}}', [
          'id' => 47,
          'carga_horaria_sem' => 8,
          'carga_horaria_cuatr' => 128,
          'cuatrimestre' => 1,
          'curso' => 3,
          'nomenclatura' => 'Aplicaciones libres',
          'plan_id' => 1,
          'departamento_id' => 1,
      ]);
      $this->insert('{{%asignatura}}', [
          'id' => 48,
          'carga_horaria_sem' => 4,
          'carga_horaria_cuatr' => 64,
          'cuatrimestre' => 1,
          'curso' => 3,
          'nomenclatura' => 'Electiva',
          'plan_id' => 1,
          'departamento_id' => 1,
      ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
      $this->dropForeignKey('planasignatura','{{%plan}}');
      $this->dropForeignKey('departamentoasignatura','{{%departamento}}');
      $this->dropTable('{{%asignatura}}');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m181217_181025_asignatura cannot be reverted.\n";

        return false;
    }
    */
}
