<?php

use yii\db\Migration;

/**
 * Class m190313_215117_firmaprograma
 */
class m190313_215117_firmaprograma extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
      $this->addColumn('{{%programa}}', 'firma', $this->text());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190313_215117_firmaprograma cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190313_215117_firmaprograma cannot be reverted.\n";

        return false;
    }
    */
}
