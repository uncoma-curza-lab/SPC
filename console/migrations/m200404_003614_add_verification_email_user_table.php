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
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200404_003614_add_verification_email_user_table cannot be reverted.\n";
        $this->dropColumn('{{%user}}', 'verification_email_token');
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
