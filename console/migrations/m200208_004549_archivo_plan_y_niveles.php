<?php

use yii\db\Migration;

/**
 * Class m200208_004549_archivo_plan_y_niveles
 */
class m200208_004549_archivo_plan_y_niveles extends Migration
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

      // agregar direccion de archivo para el plan
      $this->addColumn('{{%plan}}','archivo', $this->string());
      
      // tabla nivel (grado, pregrado, posgrado)
      $this->createTable('{{%nivel}}',[
        'id'      =>  $this->primaryKey(),
        'descripcion'   =>  $this->string()->notNull(),
      ], $options);

      /* vincular carrera con nivel */
      $this->addColumn('{{%carrera}}','nivel_id', $this->integer());
      $this->addForeignKey(
        'fk-carrera-nivel_id',
        '{{%carrera}}',
        'nivel_id',
        '{{%nivel}}',
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

        $this->dropColumn('{{%plan}}','archivo');

        $this->dropTable('{{%nivel}}');
        echo "m200208_004549_archivo_plan_y_niveles cannot be reverted.\n";
        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200208_004549_archivo_plan_y_niveles cannot be reverted.\n";

        return false;
    }
    */
}
