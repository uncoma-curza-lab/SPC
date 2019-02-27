<?php

use yii\db\Migration;

/**
 * Class m190227_170945_usuarios_fix
 */
class m190227_170945_usuarios_fix extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
      $this->delete('{{%perfil}}', [
          'user_id' => '4',
      ]);
      $this->delete('{{%perfil}}', [
          'user_id' => '5',
      ]);
      $this->delete('{{%perfil}}', [
          'user_id' => '10',
      ]);
      $this->delete('{{%perfil}}', [
          'user_id' => '9',
      ]);
      $this->delete('{{%user}}', [
          'username' => 'usuario',
      ]);
      $this->delete('{{%user}}', [
          'username' => 'superusuario',
      ]);
      $this->delete('{{%user}}', [
          'username' => 'profesor',
      ]);

      $this->delete('{{%user}}', [
          'username' => 'departamento',
      ]);
      $this->delete('{{%user}}', [
          'username' => 'departamento2',
      ]);
      $this->delete('{{%user}}', [
          'username' => 'biblioteca',
      ]);
      $this->delete('{{%user}}', [
          'username' => 'profesor2',
      ]);
      $this->alterColumn('{{%perfil}}','genero_id',$this->integer());
      $this->update('{{%perfil}}',['genero_id' => null],'genero_id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190227_170945_usuarios_fix cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190227_170945_usuarios_fix cannot be reverted.\n";

        return false;
    }
    */
}
