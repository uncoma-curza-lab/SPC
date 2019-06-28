<?php

use yii\db\Migration;

/**
 * Class m190627_201052_carreramodalidad
 */
class m190627_201052_carreramodalidad extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $options = null;
        if ( $this->db->driverName=='mysql' ) {
          $options = 'CHARACTER SET utf8 COLLATE utf8_spanish_ci ENGINE=innodb';
        }
        $this->createTable('{{%carreramodalidad}}',[
          'carrera_id'    => $this->integer(),
          'modalidad_id'  => $this->integer(),
          'PRIMARY KEY(carrera_id,modalidad_id)',
          'created_at' => $this->dateTime(),
          'updated_at' => $this->dateTime(),
          
        ], $options);
        $this->createIndex(
            'idx-cm-carrera_id',
            '{{%carreramodalidad}}',
            'carrera_id'
        );

        $this->addForeignKey(
            'fk-cm-carrera_id',
            '{{%carreramodalidad}}',
            'carrera_id',
            '{{%carrera}}',
            'id',
            'no action',
            'no action'
        );
        $this->createIndex(
            'idx-cm-modalidad_id',
            '{{%carreramodalidad}}',
            'modalidad_id'
        );
        $this->addForeignKey(
            'fk-cm-modalidad_id',
            '{{%carreramodalidad}}',
            'modalidad_id',
            '{{%modalidad}}',
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
        echo "m190627_201052_carreramodalidad revertir.\n";
        $this->dropForeignKey('fk-cm-carrera_id','{{%carreramodalidad}}');
        $this->dropIndex(
            'idx-cm-carrera_id',
            '{{%carreramodalidad}}'
        );
        $this->dropForeignKey('fk-cm-modalidad_id','{{%carreramodalidad}}');
        $this->dropIndex(
            'idx-cm-modalidad_id',
            '{{%carreramodalidad}}'
        );
        $this->dropTable('{{%carreramodalidad}}');
        return true;

    }

}
