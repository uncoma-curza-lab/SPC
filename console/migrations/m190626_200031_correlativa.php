<?php

use yii\db\Migration;

/**
 * Class m190626_200031_correlativa
 */
class m190626_200031_correlativa extends Migration
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
        $this->createTable('{{%correlativa}}',[
          'asignatura_id'     => $this->integer(),
          'correlativa_id' => $this->integer(),
          'PRIMARY KEY(asignatura_id,correlativa_id)',
          'created_at' => $this->dateTime(),
          'updated_at' => $this->dateTime(),
          
        ], $options);
        $this->createIndex(
            'idx-correlativa-asignatura_id',
            '{{%correlativa}}',
            'asignatura_id'
        );

        $this->addForeignKey(
            'fk-correlativa-asignatura_id',
            '{{%correlativa}}',
            'asignatura_id',
            '{{%asignatura}}',
            'id',
            'no action',
            'no action'
        );
        $this->createIndex(
            'idx-correlativa-correlativa_id',
            '{{%correlativa}}',
            'correlativa_id'
        );
        $this->addForeignKey(
            'fk-correlativa-correlativa_id',
            '{{%correlativa}}',
            'correlativa_id',
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
        echo "m190626_200031_correlativa va a ser revertida.\n";
        
        $this->dropForeignKey('fk-correlativa-asignatura_id','{{%correlativa}}');
        $this->dropIndex('idx-correlativa-asignatura_id','{{%correlativa}}');
        $this->dropForeignKey('fk-correlativa-correlativa_id','{{%correlativa}}');
        $this->dropIndex('idx-correlativa-correlativa_id','{{%correlativa}}');
        $this->dropTable('{{%correlativa}}');
    }

 
  
}
