<?php

use yii\db\Migration;

/**
 * Class m200330_223712_notificacion
 */
class m200330_223712_notificacion extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        /**
         * campos
         * tipo de evento
         * fecha de creacion
         * usuario emisor
         * usuario receptor
         * leido ? date else null
         * message
         * 
         */
        $options = null;
        if ( $this->db->driverName=='mysql' ) {
            $options = 'CHARACTER SET utf8 COLLATE utf8_spanish_ci ENGINE=innodb';
        }
   
        $this->createTable('{{%notification}}',[
            'id' =>  $this->primaryKey(),
            'message' =>  $this->string()->notNull(),
            'user_init' => $this->integer(),
            'user_receiver' => $this->integer(),
            'event_type_id' => $this->integer(),
            'type' => $this->string(35)->notNull(),
            'read' => $this->dateTime(),
            'programa_id' => $this->integer(),
            'created_at'  => $this->dateTime(),
            'updated_at'  => $this->dateTime(),
            'created_by'  => $this->integer(),
            'updated_by'  => $this->integer(),
        ], $options);
        $this->addForeignKey(
            'fk-event_type_id-notificacion-event_type',
            '{{%notification}}',
            'event_type_id',
            '{{%event_type}}',
            'id',
            'no action',
            'no action'
        );
        $this->addForeignKey(
            'fk-programa_id-notificacion-programa',
            '{{%notification}}',
            'programa_id',
            '{{%programa}}',
            'id',
            'no action',
            'no action'
        );

        $this->addForeignKey(
            'fk-user_init-notificacion-user',
            '{{%notification}}',
            'user_init',
            '{{%user}}',
            'id',
            'no action',
            'no action'
        );
        $this->addForeignKey(
            'fk-user_receiver-notificacion-user',
            '{{%notification}}',
            'user_receiver',
            '{{%user}}',
            'id',
            'no action',
            'no action'
        );
        $this->addForeignKey(
            'fk-updated_by-notificacion-user',
            '{{%notification}}',
            'updated_by',
            '{{%user}}',
            'id',
            'no action',
            'no action'
        );
        $this->addForeignKey(
            'fk-created_by-notificacion-user',
            '{{%notification}}',
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
        $this->dropForeignKey('fk-programa_id-notificacion-programa','{{%notification}}') ;
        $this->dropForeignKey('fk-event_type_id-notificacion-event_type','{{%notification}}') ;
        $this->dropForeignKey('fk-user_init-notificacion-user','{{%notification}}') ;
        $this->dropForeignKey('fk-user_receiver-notificacion-user','{{%notification}}') ;
        $this->dropForeignKey('fk-created_by-notificacion-user','{{%notification}}') ;
        $this->dropForeignKey('fk-updated_by-notificacion-user','{{%notification}}');
        $this->dropTable('{{%notification}}');

    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200330_223616_notificacion cannot be reverted.\n";

        return false;
    }
    */
}
