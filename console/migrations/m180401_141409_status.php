<?php

use yii\db\Migration;

/**
 * Class m180921_141409_status
 */
class m180401_141409_status extends Migration
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
      $this->createTable('{{status}}',[
        'id'      =>  $this->primaryKey(),
        'descripcion'     => $this->string()->notNull(),
        'value'           => $this->integer(3),
      ], $options);
      $this->insert('{{%status}}', [
          'id' => 1,
          'descripcion' => 'Borrador',
          'value' => 5,
      ]);
      $this->insert('{{%status}}', [
          'id' => 2,
          'descripcion' => 'Departamento',
          'value' => 10,
      ]);
      $this->insert('{{%status}}', [
          'id' => 4,
          'descripcion' => 'Administración Académica',
          'value' => 20,
      ]);
      $this->insert('{{%status}}', [
          'id' => 5,
          'descripcion' => 'Secretaría Académica',
          'value' => 30,
      ]);
      $this->insert('{{%status}}', [
          'id' => 6,
          'descripcion' => 'Biblioteca',
          'value' => 50,
      ]);
      $this->insert('{{%status}}', [
          'id' => 3,
          'descripcion' => 'En espera',
          'value' => 7,
      ]);
    }


    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{status}}');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180921_141409_status cannot be reverted.\n";

        return false;
    }
    */
}
