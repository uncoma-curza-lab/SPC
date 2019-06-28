<?php

use yii\db\Migration;

/**
 * Class m190626_192800_update_carrera
 */
class m190626_192800_update_carrera extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%carrera}}','titulo', $this->string());
        $this->addColumn('{{%carrera}}','duracion_total_hs', $this->integer()->defaultValue(-1));
        $this->addColumn('{{%carrera}}','duracion_total_anos', $this->float(2)->defaultValue(-1));
        $this->addColumn('{{%carrera}}','plan_vigente_id', $this->integer());
        $this->addColumn('{{%carrera}}','fundamentacion', $this->text());
        $this->addColumn('{{%carrera}}','perfil', $this->text());
        $this->addColumn('{{%carrera}}','alcance', $this->text());
        
        $this->addForeignKey(
            'fk-carrera-plan_vigente_id',
            '{{%carrera}}',
            'plan_vigente_id',
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
        $this->dropForeignKey('fk-carrera-plan_vigente_id','{{%carrera}}');
        $this->dropColumn('{{%carrera}}','alcance');
        $this->dropColumn('{{%carrera}}','perfil');
        $this->dropColumn('{{%carrera}}','fundamentacion');
        $this->dropColumn('{{%carrera}}','plan_vigente_id');
        $this->dropColumn('{{%carrera}}','duracion_total_anos');
        $this->dropColumn('{{%carrera}}','duracion_total_hs');
        $this->dropColumn('{{%carrera}}','titulo');
        return true;
    }

    
}
