<?php

use yii\db\Migration;

/**
 * Class m181001_121008_persona
 */
class m181001_121008_persona extends Migration
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
      $this->createTable('{{persona}}',[
          'id'      =>  $this->primaryKey(),
          'nombre' => $this->string(60)->notNull(),
          'apellido' => $this->string(60)->notNull(),
          'telefono' => $this->string(18)->notNull(),
          'direccion' => $this->string(80)->notNull(),
          'email' => $this->string(80)->notNull(),
          'cuit' => $this->string(15)->notNull(),
      ], $options);


    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{persona}}');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m181001_121008_persona cannot be reverted.\n";

        return false;
    }
    */
}
