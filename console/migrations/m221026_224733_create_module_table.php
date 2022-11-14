<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%modules}}`.
 */
class m221026_224733_create_module_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%modules}}', [
            'id' => $this->primaryKey(),
            'value' => $this->string(),
            'program_id' => $this->integer(),
            'type' => $this->string()->notNull(),
        ]);

        $this->addForeignKey(
          'program_module',
          '{{%modules}}',
          'program_id',
          'programa',
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
        $this->dropForeignKey('program_module','{{%modules}}');
        $this->dropTable('{{%modules}}');
    }
}
