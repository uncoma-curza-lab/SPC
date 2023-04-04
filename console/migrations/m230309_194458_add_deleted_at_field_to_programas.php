<?php

use yii\db\Migration;

/**
 * Class m230309_194458_add_deleted_at_field_to_programas
 */
class m230309_194458_add_deleted_at_field_to_programas extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn(
            '{{%programa}}',
            'deleted_at',
            $this->dateTime()
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn(
            '{{%programa}}',
            'deleted_at'
        );
    }
}
