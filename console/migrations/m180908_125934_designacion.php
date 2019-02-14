<?php

use yii\db\Migration;

/**
 * Class m180908_125934_designacion
 */
class m180908_125934_designacion extends Migration
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

      $this->addForeignKey(
        'cargodesignacion',
        'designacion',
        'cargo_id',
        'cargo',
        'id',
        'no action',
        'no action'
      );
      $this->addForeignKey(
        'userdesignacion',
        'designacion',
        'perfil_id',
        'perfil',
        'id',
        'no action',
        'no action'
      );
      $this->addForeignKey(
        'programadesignacion',
        'designacion',
        'programa_id',
        'programa',
        'id',
        'no action',
        'no action'
      );
      $this->addForeignKey(
        'deptodesignacion',
        'designacion',
        'departamento_id',
        'departamento',
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
        $this->dropForeignKey('programadesignacion','{{%programa}}');
        $this->dropForeignKey('deptodesignacion','{{%departamento}}');
        $this->dropForeignKey('userdesignacion','{{%perfil}}');
        $this->dropForeignKey('cargodesignacion','{{%cargo}}');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190105_175237_designacion cannot be reverted.\n";

        return false;
    }
    */
}
