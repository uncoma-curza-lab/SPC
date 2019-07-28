<?php

use yii\db\Migration;

/**
 * Class m190725_190628_titulo_intermedio
 */
class m190725_190628_titulo_intermedio extends Migration
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
        $this->createTable('{{%titulo_intermedio}}',[
            'carrera_id'  => $this->integer(),
            'titulo_intermedio_id'    => $this->integer(),
            'PRIMARY KEY(carrera_id,titulo_intermedio_id)',
            'created_at' => $this->dateTime(),
            'updated_at' => $this->dateTime(),
        ], $options);
        $this->createIndex(
            'idx-ti-carrera_id',
            '{{%titulo_intermedio}}',
            'carrera_id'
        );

        $this->addForeignKey(
            'fk-ti-carrera_id',
            '{{%titulo_intermedio}}',
            'carrera_id',
            '{{%carrera}}',
            'id',
            'no action',
            'no action'
        );
        $this->createIndex(
            'idx-ti-titulo_intermedio_id',
            '{{%titulo_intermedio}}',
            'titulo_intermedio_id'
        );
        $this->addForeignKey(
            'fk-ti-titulo_intermedio_id',
            '{{%titulo_intermedio}}',
            'titulo_intermedio_id',
            '{{%carrera}}',
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
        echo "titulo_intermedio comenzará a revertirse.\n";
        $this->dropForeignKey('fk-ti-carrera_id','{{%titulo_intermedio}}');
        $this->dropIndex(
            'idx-ti-carrera_id',
            '{{%titulo_intermedio}}'
        );
        $this->dropForeignKey('fk-ti-titulo_intermedio_id','{{%titulo_intermedio}}');
        $this->dropIndex(
            'idx-ti-titulo_intermedio_id',
            '{{%titulo_intermedio}}'
        );
        $this->dropTable('{{%titulo_intermedio}}');
        return true;
    }

}
