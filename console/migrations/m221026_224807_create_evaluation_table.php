<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%evaluation}}`.
 */
class m221026_224807_create_evaluation_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%evaluation}}', [
            'id' => $this->primaryKey(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%evaluation}}');
    }
}
