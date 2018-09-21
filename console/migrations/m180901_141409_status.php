<?php

use yii\db\Migration;

/**
 * Class m180921_141409_status
 */
class m180901_141409_status extends Migration
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
      ], $options);
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
