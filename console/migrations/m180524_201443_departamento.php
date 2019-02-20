<?php

use yii\db\Migration;

/**
 * Class m180906_124454_departamento
 */
class m180524_201443_departamento extends Migration
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
      $this->createTable('{{%departamento}}',[
        'id'      =>  $this->primaryKey(),
        'nom'     => $this->string()->notNull(),
        'slug'  => $this->string()->notNull(),
        'director' => $this->integer()
      ], $options);
      $this->createTable('{{%designacion}}',[
          'id'      =>  $this->primaryKey(),
          'cargo_id' => $this->integer(),
          'perfil_id' => $this->integer(),
          'programa_id' => $this->integer(),
          'departamento_id' => $this->integer()
      ], $options);
      $this->addForeignKey(
        'designaciondepartamento',
        'departamento',
        'director',
        'designacion',
        'id',
        'no action',
        'no action'
      );
      $this->insert('{{%departamento}}', [
          'id' => 1,
          'nom' => 'Ciencia y Tecnología',
          'slug' => 'cyt',
      ]);
      $this->insert('{{%departamento}}', [
          'id' => 2,
          'nom' => 'Lengua y comunicación',
          'slug' => 'llyc',
      ]);
      $this->insert('{{%departamento}}', [
          'id' => 3,
          'nom' => 'Psicopedagogía',
          'slug' => 'psicopedagogia',
      ]);
      $this->insert('{{%departamento}}', [
          'id' => 4,
          'nom' => 'Administración Pública',
          'slug' => 'ap',
      ]);
      $this->insert('{{%departamento}}', [
          'id' => 5,
          'nom' => 'Estudios Políticos',
          'slug' => 'ep',
      ]);
      $this->insert('{{%departamento}}', [
          'id' => 6,
          'nom' => 'Gestión Agropecuaria',
          'slug' => 'ga',
      ]);
      $this->insert('{{%departamento}}', [
          'id' => 7,
          'nom' => 'Coordinación de Licenciatura en Enfermeria',
          'slug' => 'cle',
      ]);

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
      $this->dropForeignKey('userdepartamento','{{designacion}}');
      $this->dropTable('{{departamento}}');
      $this->dropTable('{{%designacion}}');

    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180906_124454_departamento cannot be reverted.\n";

        return false;
    }
    */
}
