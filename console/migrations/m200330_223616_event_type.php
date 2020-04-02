<?php

use yii\db\Migration;

/**
 * Class m200330_223616_event_type
 */
class m200330_223616_event_type extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        /**
         * campos
         * descripcion de evento
         * templateMessage
         * 
         */
        $options = null;
        if ( $this->db->driverName=='mysql' ) {
            $options = 'CHARACTER SET utf8 COLLATE utf8_spanish_ci ENGINE=innodb';
        }
        $this->createTable('{{%event_type}}',[
            'id' =>  $this->primaryKey(),
            'descripcion' =>  $this->string()->notNull(),
            'message_template' =>  $this->string()->notNull(),
            'created_at' => $this->dateTime(),
            'updated_at'  => $this->dateTime(),
            'created_by'  => $this->integer(),
            'updated_by'  => $this->integer(),
        ], $options);
     
        $this->addForeignKey(
            'fk-updated_by-event_type-user',
            '{{%event_type}}',
            'updated_by',
            '{{%user}}',
            'id',
            'no action',
            'no action'
        );
        $this->addForeignKey(
            'fk-created_by-event_type-user',
            '{{%event_type}}',
            'created_by',
            '{{%user}}',
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
        echo "m200330_223616_notificacion será revertido...\n";
        $this->dropForeignKey('fk-created_by-event_type-user','{{%event_type}}');
        $this->dropForeignKey('fk-updated_by-event_type-user','{{%event_type}}');
        $this->dropTable('{{%event_type}}');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200330_223647_event_type cannot be reverted.\n";

        return false;
    }
    */
}
