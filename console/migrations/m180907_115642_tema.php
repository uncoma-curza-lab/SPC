<?php

use yii\db\Migration;

/**
 * Class m180907_115642_tema
 */
class m180907_115642_tema extends Migration
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
      $this->createTable('{{tema}}',[
          'id'      =>  $this->primaryKey(),
          'descripcion' => $this->string()->notNull(),
          'unidad_id' => $this->integer()
      ], $options);

      $this->addForeignKey(
        'unidadtema',
        'tema',
        'unidad_id',
        'unidad',
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
      $this->dropForeignKey('unidadtema','{{unidad}}');
      $this->dropTable('{{tema}}');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180907_115642_tema cannot be reverted.\n";

        return false;
    }
    */
}
