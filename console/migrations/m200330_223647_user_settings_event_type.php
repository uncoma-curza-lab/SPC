<?php

use yii\db\Migration;

/**
 * Class m200330_223647_user_settings_event_type
 */
class m200330_223647_user_settings_event_type extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        /**
         * campos
         * usuario
         * tipo de notificacion
         * Habilitado?? la idea es si lo deshabilita -> guardar registro, sino tomar como true.
         */
        $options = null;
        if ( $this->db->driverName=='mysql' ) {
            $options = 'CHARACTER SET utf8 COLLATE utf8_spanish_ci ENGINE=innodb';
        }
        $this->createTable('{{%user_settings_event_type}}',[
            'id' =>  $this->primaryKey(),
            'event_type_id' => $this->integer(), 
            'user_id'  => $this->integer(),
            'active' => $this->boolean(),
            'created_at' => $this->dateTime(),
            'updated_at'  => $this->dateTime(),
            'created_by'  => $this->integer(),
            'updated_by'  => $this->integer(),
        ], $options);
        $this->addForeignKey(
            'fk-event_type_id-uset-event_type',
            '{{%user_settings_event_type}}',
            'event_type_id',
            '{{%event_type}}',
            'id',
            'no action',
            'no action'
        );
        $this->addForeignKey(
            'fk-user_id-uset-user',
            '{{%user_settings_event_type}}',
            'user_id',
            '{{%user}}',
            'id',
            'no action',
            'no action'
        );
        $this->addForeignKey(
            'fk-updated_by-uset-user',
            '{{%user_settings_event_type}}',
            'updated_by',
            '{{%user}}',
            'id',
            'no action',
            'no action'
        );
        $this->addForeignKey(
            'fk-created_by-uset-user',
            '{{%user_settings_event_type}}',
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
        echo "User Settings Event Type intentará revertirse...\n";
        $this->dropForeignKey('fk-event_type_id-uset-event_type','{{%user_settings_event_type}}');
        $this->dropForeignKey('fk-user_id-uset-user','{{%user_settings_event_type}}');
        $this->dropForeignKey('fk-created_by-uset-user','{{%user_settings_event_type}}');
        $this->dropForeignKey('fk-updated_by-uset-user','{{%user_settings_event_type}}');
        $this->dropTable('{{%user_settings_event_type}}');
        
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200330_223712_user_settings_event_type cannot be reverted.\n";

        return false;
    }
    */
}
