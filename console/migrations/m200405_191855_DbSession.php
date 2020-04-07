<?php

use yii\db\Migration;

/**
 * Class m200405_191855_DbSession
 */
class m200405_191855_DbSession extends Migration
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
   
        $this->createTable('{{%user_session}}',[
            'id' =>  'CHAR(40) NOT NULL PRIMARY KEY',
            'expire' =>  $this->integer(),
            'data' => 'LONGBLOB',
        ], $options);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200405_191855_DbSession cannot be reverted.\n";
        $this->dropTable('{{%user_session}}');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200405_191855_DbSession cannot be reverted.\n";

        return false;
    }
    */
}
