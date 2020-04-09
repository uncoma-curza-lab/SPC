<?php

use yii\db\Migration;

/**
 * Class m200409_045532_control_settings_admin
 */
class m200409_045532_control_settings_admin extends Migration
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
   
        $this->createTable('{{%control_notification}}',[
            'id' =>  $this->primaryKey(),
            'active' => $this->boolean()->defaultValue(false),
            'notification_name' => $this->string()->notNull()->unique(),
            'created_at'  => $this->dateTime(),
            'updated_at'  => $this->dateTime(),
            'created_by'  => $this->integer(),
            'updated_by'  => $this->integer(),
        ], $options);
      
        $this->addForeignKey(
            'fk-updated_by-control_notification-user',
            '{{%control_notification}}',
            'updated_by',
            '{{%user}}',
            'id',
            'no action',
            'no action'
        );
        $this->addForeignKey(
            'fk-created_by-control_notification-user',
            '{{%control_notification}}',
            'created_by',
            '{{%user}}',
            'id',
            'no action',
            'no action'
        );
        $this->insert('{{%control_notification}}', [
            'notification_name' =>  "NotificationPanel",
            'active' => true,
        ]);
        $this->insert('{{%control_notification}}', [
            'notification_name' =>  "NotificationEmail",
            'active' => true,
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200409_045532_control_settings_admin can be reverted.\n";
        $this->dropForeignKey('fk-created_by-control_notification-user','{{%control_notification}}') ;
        $this->dropForeignKey('fk-updated_by-control_notification-user','{{%control_notification}}');
        $this->dropTable('{{%control_notification}}');
        
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200409_045532_control_settings_admin cannot be reverted.\n";

        return false;
    }
    */
}
