<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%reviews}}`.
 */
class m221026_224807_create_reviews_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%reviews}}', [
            'id' => $this->primaryKey(),
            'program_id' => $this->integer()->notNull(),
            'area' => $this->string()->notNull(),
            'observation_id' => $this->integer(),
            'module_id' => $this->integer(),
            'resolution' => "ENUM('approve', 'rejected')"
        ]);

        $this->addForeignKey(
          'program_review',
          '{{%reviews}}',
          'program_id',
          '{{%programa}}',
          'id',
          'no action',
          'no action'
        );

        $this->addForeignKey(
          'module_review',
          '{{%reviews}}',
          'module_id',
          '{{%modules}}',
          'id',
          'no action',
          'no action'
        );

        $this->addForeignKey(
          'observation_review',
          '{{%reviews}}',
          'observation_id',
          '{{%observacion}}',
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
        $this->dropForeignKey('observation_review','{{%reviews}}');
        $this->dropForeignKey('module_review','{{%reviews}}');
        $this->dropForeignKey('program_review','{{%reviews}}');
        $this->dropTable('{{%reviews}}');
    }
}
