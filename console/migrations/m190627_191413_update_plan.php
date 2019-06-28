<?php

use yii\db\Migration;

/**
 * Class m190627_191413_update_plan
 */
class m190627_191413_update_plan extends Migration
{

    public function safeUp()
    {
        $this->addColumn('{{%plan}}','activo', $this->boolean()->defaultValue(false));

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190627_191413_update_plan será revertido.\n";
        $this->dropColumn('{{%plan}}','activo');
        //return false;
    }

}
