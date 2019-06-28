<?php

use yii\db\Migration;

/**
 * Class m190626_192619_modalidad
 */
class m190626_192619_modalidad extends Migration
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
        $this->createTable('{{%modalidad}}',[
          'id'      =>  $this->primaryKey(),
          'nombre'     => $this->string()->notNull(),
          'descripcion' => $this->string()
          
        ], $options);
        
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%modalidad}}');

    }

   
}
