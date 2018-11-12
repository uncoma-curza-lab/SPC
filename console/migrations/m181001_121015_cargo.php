<?php

use yii\db\Migration;

/**
 * Class m181001_121015_cargo
 */
class m181001_121015_cargo extends Migration
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
      $this->createTable('{{cargo}}',[
          'id'      =>  $this->primaryKey(),
          'designacion' => $this->string()->notNull(),
          'nombre_persona' => $this->string(100)->notNull,
          'programa_id' => $this->integer()
      ], $options);

      $this->addForeignKey(
        'programacargo',
        'cargo',
        'programa_id',
        'programa',
        'id',
        'no action',
        'no action'
      );
      $this->addForeignKey(
        'personacargo',
        'cargo',
        'persona_id',
        'persona',
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
      $this->dropForeignKey('programacargo','{{programa}}');
      $this->dropForeignKey('personacargo','{{persona}}');
      $this->dropTable('{{cargo}}');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m181001_121015_cargo cannot be reverted.\n";

        return false;
    }
    */
}
