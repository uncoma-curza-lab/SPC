<?php

use yii\db\Migration;

/**
 * Class m240508_024905_course_syllabus_view
 */
class m240725_033901_add_role_auxiliar_department extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->insert('{{%rol}}', [
            'rol_nombre' => 'Aux_departamento',
            'rol_valor' => 50
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->delete('{{%rol}}', ['rol_nombre' => 'Aux_departamento']);
    }
}
