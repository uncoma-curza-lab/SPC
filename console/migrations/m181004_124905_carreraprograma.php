<?php

use yii\db\Migration;

/**
 * Class m181004_124905_carreraprograma
 */
class m181004_124905_carreraprograma extends Migration
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
      $this->createTable('{{carreraprograma}}',[
        'id'      =>  $this->primaryKey(),
        'carrera_id' => $this->integer(),
        'programa_id' => $this->integer(),
      ], $options);

      $this->addForeignKey(
        'carreracarreraP',
        'carreraprograma',
        'carrera_id',
        'carrera',
        'id',
        'no action',
        'no action'
      );
      $this->addForeignKey(
        'programacarrera',
        'carreraprograma',
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
      $this->dropForeignKey('carreracarreaP','{{carerra}}');
      $this->dropForeignKey('programacarrera','{{programa}}');
      $this->dropTable('{{carreraprograma}}');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m181004_124905_carreraprograma cannot be reverted.\n";

        return false;
    }
    */
}
