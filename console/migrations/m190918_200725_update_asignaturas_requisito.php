<?php

use yii\db\Migration;

/**
 * Class m190918_200725_update_asignaturas_requisito
 */
class m190918_200725_update_asignaturas_requisito extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%asignatura}}','requisitos', $this->text());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {

        $this->dropColumn('{{%asignatura}}','requisitos');

    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190918_200725_update_asignaturas_requisito cannot be reverted.\n";

        return false;
    }
    */
}
