<?php

use yii\db\Migration;

/**
 * Class m200404_003614_add_verification_email_user_table
 */
class m200404_003614_add_verification_email_user_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%user}}', 'verification_email_token', $this->string()->defaultValue(null));
        $this->insert('{{%estado}}', [
            'estado_nombre' =>  "Bloqueado",
            'estado_valor' => "0",
        ]);
        $this->insert('{{%estado}}', [
            'estado_nombre' =>  "VerificarEmail",
            'estado_valor' => "7",
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200404_003614_add_verification_email_user_table cannot be reverted.\n";
        $this->dropColumn('{{%user}}', 'verification_email_token');
        $this->delete('{{%estado}}',['estado_nombre' => 'VerificarEmail']);
        $this->delete('{{%estado}}',['estado_nombre' => 'Bloqueado']);
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200404_003614_add_verification_email_user_table cannot be reverted.\n";

        return false;
    }
    */
}
