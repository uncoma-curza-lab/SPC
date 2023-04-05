<?php

use yii\db\Migration;

/**
 * Class m230322_024222_add_parents_courses_table
 */
class m230322_024222_add_parents_courses_table extends Migration
{
    public function safeUp()
    {
        $this->addColumn(
            '{{%asignatura}}',
            'parent_id',
            $this->integer()
        );

        $this->addForeignKey(
          'course_amending_parent',
          '{{%asignatura}}',
          'parent_id',
          '{{%asignatura}}',
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
        $this->dropForeignKey('course_amending_parent', '{{%asignatura}}');

        $this->dropColumn('{{%asignatura}}', 'parent_id');
    }
}
