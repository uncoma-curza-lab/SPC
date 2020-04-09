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
            'slug' => $this->string()->notNull()->unique(),
            'name' => $this->string()->notNull(),
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
        $this->insert('{{%event_type}}', [
            'descripcion' =>  "Observación en programa",
            'slug' => "crear-observacion",
            'name' => "Creación de observacion",
            'message_template' => 'Hubo una observación en el programa "%programa%" por parte del usuario %user_init%',
            'created_at' => '2020-04-01 00:00:00',
            'updated_at' => '2020-04-01 00:00:00',
        ]);
        $this->insert('{{%event_type}}', [
            'descripcion' =>  "Se rechazó un programa",
            'slug' => "rechazar-programa",
            'name' => "Rechazar Programa",
            'message_template' => 'El programa de cátedra %programa% ha sido rechazado por %user_init%, su estado actual es: %estado_programa%',
            'created_at' => '2020-04-01 00:00:00',
            'updated_at' => '2020-04-01 00:00:00',
            
        ]);
        $this->insert('{{%event_type}}', [
            'descripcion' =>  "Se aprobó un programa",
            'slug' => "aprobar-programa",
            'name' => "Aprobar Programa",
            'message_template' => 'El programa de cátedra %programa% ha sido aprobado por %user_init%, su estado actual es: %estado_programa%',
            'created_at' => '2020-04-01 00:00:00',
            'updated_at' => '2020-04-01 00:00:00',
            
        ]);
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
