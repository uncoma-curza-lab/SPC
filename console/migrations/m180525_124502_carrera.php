<?php

use yii\db\Migration;

/**
 * Class m180906_124502_carrera
 */
class m180525_124502_carrera extends Migration
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
      $this->createTable('{{carrera}}',[
        'id'      =>  $this->primaryKey(),
        'nom'     => $this->string()->notNull(),
        'codigo'  => $this->integer(),
        'departamento_id' => $this->integer(),
      ], $options);

      $this->addForeignKey(
        'departamentocarrera',
        'carrera',
        'departamento_id',
        'departamento',
        'id',
        'no action',
        'no action'
      );
      $this->insert('{{%carrera}}', [
          'id' => 1,
          'nom' => 'Tec. Universitaria en Administración de Sistemas y Software Libre',
          //'codigo' => 123,
          'departamento_id' => '1',
      ]);
      $this->insert('{{%carrera}}', [
          'id' => 2,
          'nom' => 'Tec. Universitaria en Desarrollo Web',
          //'codigo' => 123,
          'departamento_id' => '1',
      ]);
      $this->insert('{{%carrera}}', [
          'id' => 3,
          'nom' => 'Profesorado de Lengua y Comunicación Oral y Escrita',
          //'codigo' => 433,
          'departamento_id' => '2',
      ]);
      $this->insert('{{%carrera}}', [
          'id' => 4,
          'nom' => 'Licenciatura en Psicopedagogía',
          //'codigo' => 45,
          'departamento_id' => '3',
      ]);
      $this->insert('{{%carrera}}', [
          'id' => 5,
          'nom' => 'Licenciatura en Administración Pública',
          //'codigo' => 45,
          'departamento_id' => '4',
      ]);
      $this->insert('{{%carrera}}', [
          'id' => 6,
          'nom' => 'Tecnicatura Superior en Administración Pública',
          //'codigo' => 45,
          'departamento_id' => '4',
      ]);
      $this->insert('{{%carrera}}', [
          'id' => 7,
          'nom' => 'Licenciatura en Gestión de Recursos Humanos',
          //'codigo' => 45,
          'departamento_id' => '4',
      ]);
      $this->insert('{{%carrera}}', [
          'id' => 8,
          'nom' => 'Profesorado en Psicopedagogía',
          //'codigo' => 45,
          'departamento_id' => '3',
      ]);
      $this->insert('{{%carrera}}', [
          'id' => 9,
          'nom' => 'Licenciatura en Ciencia Política',
          //'codigo' => 45,
          'departamento_id' => '5',
      ]);
      $this->insert('{{%carrera}}', [
          'id' => 10,
          'nom' => 'Profesorado Universitario en Ciencia Política',
          //'codigo' => 45,
          'departamento_id' => '5',
      ]);
      $this->insert('{{%carrera}}', [
          'id' => 11,
          'nom' => 'Licenciatura en Gestión de Empresas Agropecuarias',
          //'codigo' => 45,
          'departamento_id' => '6',
      ]);
      $this->insert('{{%carrera}}', [
          'id' => 12,
          'nom' => 'Profesorado en Ciencias Agropecuarias',
          //'codigo' => 45,
          'departamento_id' => '6',
      ]);
      $this->insert('{{%carrera}}', [
          'id' => 13,
          'nom' => 'Tecnicatura Superior en Producción Agropecuaria',
          //'codigo' => 45,
          'departamento_id' => '6',
      ]);
      $this->insert('{{%carrera}}', [
          'id' => 14,
          'nom' => 'Licenciatura en Enfermería',
          //'codigo' => 45,
          'departamento_id' => '7',
      ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
      $this->dropForeignKey('departamentocarrea','{{departamento}}');
      $this->dropTable('{{carrera}}');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180906_124502_carrera cannot be reverted.\n";

        return false;
    }
    */
}
