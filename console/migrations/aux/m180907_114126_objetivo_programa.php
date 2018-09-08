<?php

use yii\db\Migration;

/**
 * Class m180907_114126_objetivo_programa
 */
class m180907_114126_objetivo_programa extends Migration
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
      $this->createTable('{{objetivo_programa}}',[
          'id'      =>  $this->primaryKey(),
          'descripcion' => $this->string()->notNull(),
          'programa_id' => $this->integer()
      ], $options);

      $this->addForeignKey(
        'programaobjetivo',
        'objetivo',
        'programa_id',
        'programa',
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
      $this->dropForeignKey('programaobjetivo','{{programa}}');
      $this->dropTable('{{objetivo_programa}}');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180907_114126_objetivo_programa cannot be reverted.\n";

        return false;
    }
    */
}
