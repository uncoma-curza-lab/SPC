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
            'origin_plan_id',
            $this->integer()
        );

        $this->createIndex('origin_plan_id_index', '{{%plan}}', 'origin_plan_id');

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
          'plan_origin',
          'plan',
          'origin_plan_id',
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
        $this->dropForeignKey('plan_origin', '{{%plan}}');
        $this->dropForeignKey('plan_or_amending_parent', '{{%plan}}');

        $this->dropColumn('{{%plan}}', 'parent_id');
        $this->dropColumn('{{%plan}}', 'origin_plan_id');
    }

}
