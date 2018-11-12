<?php

use yii\db\Schema;
use yii\db\Migration;

class m130524_201442_init extends Migration
{
    private $tableOptions;

    public function up()
    {
        $this->tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $this->tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        // estado
        $this->createTable('{{%estado}}', [
            'id' => Schema::TYPE_PK,
            'estado_nombre' => Schema::TYPE_STRING . "(45) NOT NULL",
            'estado_valor' => Schema::TYPE_INTEGER . "(11) NOT NULL",
            'created_by' => Schema::TYPE_INTEGER . "(11) NOT NULL",
            'updated_by' => Schema::TYPE_INTEGER . "(11) NOT NULL",
        ], $this->tableOptions);

            $this->insert('{{%estado}}', [
                'id' => 1,
                'estado_nombre' => 'Activo',
                'estado_valor' => 10,
            ]);
            $this->insert('{{%estado}}', [
                'id' => 2,
                'estado_nombre' => 'Pendiente',
                'estado_valor' => 5,
            ]);

        // genero
        $this->createTable('{{%genero}}', [
            'id' => Schema::TYPE_PK,
            'genero_nombre' => Schema::TYPE_STRING . "(45) NOT NULL",
        ], $this->tableOptions);

            $this->insert('{{%genero}}', [
                'id' => 1,
                'genero_nombre' => 'masculino',
            ]);
            $this->insert('{{%genero}}', [
                'id' => 2,
                'genero_nombre' => 'femenino',
            ]);

        // perfil
        $this->createTable('{{%perfil}}', [
            'id' => Schema::TYPE_PK,
            'user_id' => Schema::TYPE_INTEGER . "(11) NOT NULL",
            'nombre' => Schema::TYPE_TEXT . " NULL",
            'apellido' => Schema::TYPE_TEXT . " NULL",
            'fecha_nacimiento' => Schema::TYPE_DATE . " NULL",
            'genero_id' => Schema::TYPE_INTEGER . "(11) NOT NULL",
            'departamento_id' => Schema::TYPE_INTEGER . "(11) NOT NULL",
            'imagen' => Schema::TYPE_STRING . "(80) NOT NULL",
            'created_at' => Schema::TYPE_DATETIME . " NULL",
            'updated_at' => Schema::TYPE_DATETIME . " NULL",
            'created_by' => Schema::TYPE_INTEGER . "(11) NOT NULL",
            'updated_by' => Schema::TYPE_INTEGER . "(11) NOT NULL",
        ], $this->tableOptions);

            $this->insert('{{%perfil}}', [
                'id' => 1,
                'user_id' => '4',
                'nombre' => 'profesor',
                'apellido' => 'profesor',
                'genero_id' => 1,
                'departamento_id' => 1,
            ]);
            $this->insert('{{%perfil}}', [
                'id' => 2,
                'user_id' => '5',
                'nombre' => 'departamento',
                'apellido' => 'departamento',
                'genero_id' => 1,
                'departamento_id' => 1,
            ]);
            $this->insert('{{%perfil}}', [
                'id' => 4,
                'user_id' => '9',
                'nombre' => 'profesor2',
                'apellido' => 'profesor2',
                'genero_id' => 2,
                'departamento_id' => 2,
            ]);

        // rol
        $this->createTable('{{%rol}}', [
            'id' => Schema::TYPE_PK,
            'rol_nombre' => Schema::TYPE_STRING . "(45) NOT NULL",
            'rol_valor' => Schema::TYPE_INTEGER . "(11) NOT NULL",
        ], $this->tableOptions);

            $this->insert('{{%rol}}', [
                'id' => 1,
                'rol_nombre' => 'Usuario',
                'rol_valor' => 20,
            ]);
            $this->insert('{{%rol}}', [
                'id' => 2,
                'rol_nombre' => 'Admin',
                'rol_valor' => 120,
            ]);
            $this->insert('{{%rol}}', [
                'id' => 3,
                'rol_nombre' => 'SuperUsuario',
                'rol_valor' => 150,
            ]);
            $this->insert('{{%rol}}', [
                'id' => 4,
                'rol_nombre' => 'Profesor',
                'rol_valor' => 40,
            ]);
            $this->insert('{{%rol}}', [
                'id' => 5,
                'rol_nombre' => 'Departamento',
                'rol_valor' => 60,
            ]);
            $this->insert('{{%rol}}', [
                'id' => 6,
                'rol_nombre' => 'Adm_academica',
                'rol_valor' => 80,
            ]);
            $this->insert('{{%rol}}', [
                'id' => 7,
                'rol_nombre' => 'Sec_academica',
                'rol_valor' => 100,
            ]);
            $this->insert('{{%rol}}', [
                'id' => 8,
                'rol_nombre' => 'Biblioteca',
                'rol_valor' => 50,
            ]);

        // tipo_usuario
        $this->createTable('{{%tipo_usuario}}', [
            'id' => Schema::TYPE_PK,
            'tipo_usuario_nombre' => Schema::TYPE_STRING . "(45) NOT NULL",
            'tipo_usuario_valor' => Schema::TYPE_INTEGER . "(11) NOT NULL",
        ], $this->tableOptions);

            $this->insert('{{%tipo_usuario}}', [
                'id' => 1,
                'tipo_usuario_nombre' => 'Gratuito',
                'tipo_usuario_valor' => 10,
            ]);
            $this->insert('{{%tipo_usuario}}', [
                'id' => 2,
                'tipo_usuario_nombre' => 'Pago',
                'tipo_usuario_valor' => 30,
            ]);

        // user
        $this->createTable('{{%user}}', [
            'id' => Schema::TYPE_PK,
            'username' => Schema::TYPE_STRING . "(255) NOT NULL",
            'auth_key' => Schema::TYPE_STRING . "(32) NOT NULL",
            'password_hash' => Schema::TYPE_STRING . "(255) NOT NULL",
            'password_reset_token' => Schema::TYPE_STRING . "(255) NULL",
            'email' => Schema::TYPE_STRING . "(255) NOT NULL",
            'rol_id' => Schema::TYPE_INTEGER . "(11) NOT NULL DEFAULT '1'",
            'estado_id' => Schema::TYPE_INTEGER . "(11) NOT NULL DEFAULT '1'",
            'tipo_usuario_id' => Schema::TYPE_INTEGER . "(11) NOT NULL DEFAULT '1'",
            'created_at' => Schema::TYPE_DATETIME . " NOT NULL",
            'updated_at' => Schema::TYPE_DATETIME . " NOT NULL",
        ], $this->tableOptions);

            $this->insert('{{%user}}', [
                'id' => 1,
                'username' => 'admin',
                'auth_key' => '12pemSeqcG-ov-bgrrsQli74vxmmzPOC',
                'password_hash' => '$2y$13$G1T2QXJ5sBrsvKb3p61vFek301wWxh/EFIfqCdJXPLnavzyBh4lC2', // admin
                'password_reset_token' => null,
                'email' => 'admin@email.com',
                'rol_id' => 2,
                'estado_id' => 1,
                'tipo_usuario_id' => 1,
                'created_at' => '2015-01-01 00:00:00',
                'updated_at' => '2015-01-01 00:00:00',
            ]);
            $this->insert('{{%user}}', [
                'id' => 2,
                'username' => 'usuario',
                'auth_key' => 'ZF88G45g6AamJlaVKb-aj4A8YEvmQjxz',
                'password_hash' => '$2y$13$dsEiz9MkhNOz6dQaJgQb.uc40wrL9uBcuB2O90.R7U3jXlcz9hUR2', // usuario
                'password_reset_token' => null,
                'email' => 'usuario@email.com',
                'rol_id' => 1,
                'estado_id' => 1,
                'tipo_usuario_id' => 1,
                'created_at' => '2015-01-01 00:00:00',
                'updated_at' => '2015-01-01 00:00:00',
            ]);
            $this->insert('{{%user}}', [
                'id' => 3,
                'username' => 'superusuario',
                'auth_key' => 'Om3xl7PrKHacvNFLyeiDsCxo3TUhU_n0',
                'password_hash' => '$2y$13$i4wfK06f3H4nWGxTtR0Y0.wbNBEJtpgW6.1zwtwU3mjd6socf9/Hu', //superusuario
                'password_reset_token' => null,
                'email' => 'superusuario@email.com',
                'rol_id' => 3,
                'estado_id' => 1,
                'tipo_usuario_id' => 1,
                'created_at' => '2015-01-01 00:00:00',
                'updated_at' => '2015-01-01 00:00:00',
            ]);
            $this->insert('{{%user}}', [
                'id' => 4,
                'username' => 'profesor',
                'auth_key' => 'bQYCliZJp_Pxx81t56_tMZ5ojXA84g5p',
                'password_hash' => '$2y$13$5Zcu8bOU3g38XxSQduUKNe2sbBf1Cssd7rZ8qJgL/Xzif6bWjllKm', //profesor
                'password_reset_token' => null,
                'email' => 'profesor@email.com',
                'rol_id' => 4,
                'estado_id' => 1,
                'tipo_usuario_id' => 1,
                'created_at' => '2015-01-01 00:00:00',
                'updated_at' => '2015-01-01 00:00:00',
            ]);

            $this->insert('{{%user}}', [
                'id' => 5,
                'username' => 'departamento',
                'auth_key' => 's9Bwu2WIpDuTf1-MwNg1idNdpXpd9Q3J',
                'password_hash' => '$2y$13$qXmkrgjd99oVALp.i7Ake.XOpldPn0vtyHtcwWEZkJYBm9EJ1zFG2', //departamento
                'password_reset_token' => null,
                'email' => 'departamento@email.com',
                'rol_id' => 5,
                'estado_id' => 1,
                'tipo_usuario_id' => 1,
                'created_at' => '2015-01-01 00:00:00',
                'updated_at' => '2015-01-01 00:00:00',
            ]);
            $this->insert('{{%user}}', [
                'id' => 8,
                'username' => 'biblioteca',
                'auth_key' => 'kNM5QVjArxGKylCrvUKgyzRNnPaoCCCA',
                'password_hash' => '$2y$13$peVfPVGTk/mOPGFmOqnl1uSogjeWvvwbCUuie87k1vscqty.dS6uS', //biblioteca
                'password_reset_token' => null,
                'email' => 'biblioteca@email.com',
                'rol_id' => 8,
                'estado_id' => 1,
                'tipo_usuario_id' => 1,
                'created_at' => '2015-01-01 00:00:00',
                'updated_at' => '2015-01-01 00:00:00',
            ]);
            $this->insert('{{%user}}', [
                'id' => 9,
                'username' => 'profesor2',
                //profesor pass
                'auth_key' => 'bQYCliZJp_Pxx81t56_tMZ5ojXA84g5p',
                'password_hash' => '$2y$13$5Zcu8bOU3g38XxSQduUKNe2sbBf1Cssd7rZ8qJgL/Xzif6bWjllKm', //profesor
                'password_reset_token' => null,
                'email' => 'profesor@email.com',
                'rol_id' => 4,
                'estado_id' => 1,
                'tipo_usuario_id' => 1,
                'created_at' => '2015-01-01 00:00:00',
                'updated_at' => '2015-01-01 00:00:00',
            ]);


        // fk: perfil
        $this->addForeignKey('fk_perfil_genero_id', '{{%perfil}}', 'genero_id', '{{%genero}}', 'id','RESTRICT','CASCADE'); // $delete= 'RESTRICT' $update='CASCADE'
        $this->addForeignKey('fk_perfil_departamento_id', '{{%perfil}}', 'departamento_id', '{{%departamento}}', 'id','RESTRICT','CASCADE'); // $delete= 'RESTRICT' $update='CASCADE'

    }

    public function down()
    {
        $this->dropForeignKey('fk_perfil_genero_id', '{{%perfil}}');
        $this->dropForeignKey('fk_perfil_departamento_id', '{{%departamento}}');
        $this->dropTable('{{%estado}}');
        $this->truncateTable('{{%perfil}}');
        $this->dropTable('{{%perfil}}'); // fk: genero_id
        $this->dropTable('{{%genero}}');
        $this->dropTable('{{%rol}}');
        $this->dropTable('{{%tipo_usuario}}');
        $this->dropTable('{{%user}}');
    }
}
