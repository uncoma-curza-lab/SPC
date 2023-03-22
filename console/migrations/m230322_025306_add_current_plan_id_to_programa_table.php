<?php

use yii\db\Migration;

/**
 * Class m230322_025306_add_current_plan_id_to_programa_table
 */
class m230322_025306_add_current_plan_id_to_programa_table extends Migration
{
    public function safeUp()
    {
        $this->addColumn(
            '{{%programa}}',
            'current_plan_id',
            $this->integer()
        );

        $this->addForeignKey(
          'current_plan_id_to_plan',
          '{{%programa}}',
          'current_plan_id',
          '{{%plan}}',
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
        $this->dropForeignKey('current_plan_id_to_plan', '{{%programa}}');

        $this->dropColumn('{{%programa}}', 'current_plan_id');
    }
}
