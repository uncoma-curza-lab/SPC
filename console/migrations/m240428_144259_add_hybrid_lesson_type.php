<?php

use yii\db\Migration;

/**
 * Class m240428_144259_add_hybrid_lesson_type
 */
class m240428_144259_add_hybrid_lesson_type extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        echo 'Add Modalidad de presencialidad hibrida/combinada.\n';

        $this->insert(
            '{{%lesson_types}}',
            [
                'description' => "Modalidad de presencialidad híbrida/combinada",
                'max_use_percentage' => 100,
            ],
        );

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m240428_144259_add_hybrid_lesson_type cannot be reverted.\n";

        $this->delete(
            '{{%lesson_types}}',
            [
                'description' => "Modalidad de presencialidad híbrida/combinada",
                'max_use_percentage' => 100,
            ],
        );

    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m240428_144259_add_hybrid_lesson_type cannot be reverted.\n";

        return false;
    }
    */
}
