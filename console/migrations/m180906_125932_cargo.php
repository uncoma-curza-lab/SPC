<?php

use yii\db\Migration;

/**
 * Class m180906_125932_cargo
 */
class m180906_125932_cargo extends Migration
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
      $this->createTable('{{%cargo}}',[
          'id'      =>  $this->primaryKey(),
          'nomenclatura' => $this->string(),
          'carga_programa' => $this->boolean()->unique(),
      ], $options);
      $this->insert('{{%cargo}}', [
          'id' => 1,
          'nomenclatura' => 'Profesor Adjunto Regular',
          'carga_programa' => true,
      ]);
      $this->insert('{{%cargo}}', [
          'id' => 2,
          'nomenclatura' => 'Asistente de Docencia Regular',
      ]);
      $this->insert('{{%cargo}}', [
          'id' => 3,
          'nomenclatura' => 'Ayudante de primera',
      ]);
      $this->insert('{{%cargo}}', [
          'id' => 4,
          'nomenclatura' => 'Ayudante de segunda',
      ]);

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
      $this->dropTable('{{%cargo}}');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m181001_121015_cargo cannot be reverted.\n";

        return false;
    }
    */
}
