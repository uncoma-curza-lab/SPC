<?php

use yii\db\Migration;

/**
 * Class m230322_024150_add_parents_plan
 */
class m230322_024150_add_parents_plan extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn(
            '{{%plan}}',
            'parent_id',
            $this->integer()
        );

        $this->addColumn(
            '{{%plan}}',
            'root_plan_id',
            $this->integer()
        );

        $this->createIndex('root_plan_id_index', '{{%plan}}', 'root_plan_id');

        $this->addForeignKey(
          'plan_or_amending_parent',
          'plan',
          'parent_id',
          'plan',
          'id',
          'no action',
          'no action'
        );

        $this->addForeignKey(
          'plan_root',
          'plan',
          'root_plan_id',
          'plan',
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
        $this->dropForeignKey('plan_root', '{{%plan}}');
        $this->dropForeignKey('plan_or_amending_parent', '{{%plan}}');

        $this->dropColumn('{{%plan}}', 'parent_id');
        $this->dropColumn('{{%plan}}', 'root_plan_id');
    }

}
