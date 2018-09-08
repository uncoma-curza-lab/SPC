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
