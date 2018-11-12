<?php

use yii\db\Migration;

/**
 * Class m180906_124502_carrera
 */
class m180906_124502_carrera extends Migration
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
          'nom' => 'Tec. en administración de sistemas y soft libre',
          'codigo' => 123,
          'departamento_id' => '1',
      ]);
      $this->insert('{{%carrera}}', [
          'id' => 2,
          'nom' => 'Profesorado en lengua y comunicación',
          'codigo' => 433,
          'departamento_id' => '2',
      ]);
      $this->insert('{{%carrera}}', [
          'id' => 3,
          'nom' => 'Licenciatura',
          'codigo' => 45,
          'departamento_id' => '3',
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
