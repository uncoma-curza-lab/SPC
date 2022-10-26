<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%distribucion_horaria}}`.
 */
class m221026_224750_create_distribucion_horaria_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%lesson_types}}', [
            'id' => $this->primaryKey(),
            'description' => $this->integer()->notNull(),
        ]);

        $this->createTable('{{%time_distribution}}', [
            'id' => $this->primaryKey(),
            'module_id' => $this->integer()->notNull(),
            'lesson_type_id' => $this->integer()->notNull(),
            'percentage_quantity' => $this->integer(),
        ]);

        $this->addForeignKey(
          'time_distribution_module',
          '{{%time_distribution}}',
          'module_id',
          '{{%modules}}',
          'id',
          'no action',
          'no action'
        );
        $this->addForeignKey(
          'time_distribution_lesson_type',
          '{{%time_distribution}}',
          'lesson_type_id',
          '{{%lesson_types}}',
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
        $this->dropForeignKey('time_distribution_module','{{%time_distribution}}');
        $this->dropForeignKey('time_distribution_lesson_type','{{%time_distribution}}');
        $this->dropTable('{{%time_distribution}}');
        $this->dropTable('{{%lesson_types}}');
    }
}
