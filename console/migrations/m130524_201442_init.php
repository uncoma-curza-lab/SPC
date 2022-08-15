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
            'created_by' => Schema::TYPE_TIMESTAMP . " NOT NULL DEFAULT CURRENT_TIMESTAMP",
            'updated_by' => Schema::TYPE_TIMESTAMP . " NOT NULL DEFAULT CURRENT_TIMESTAMP",
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
            'user_id' => Schema::TYPE_INTEGER . "(11)",
            'nombre' => Schema::TYPE_TEXT . " NULL",
            'apellido' => Schema::TYPE_TEXT . " NULL",
            'fecha_nacimiento' => Schema::TYPE_DATE . " NULL",
            'genero_id' => Schema::TYPE_INTEGER . "(11) NOT NULL",
            'imagen' => Schema::TYPE_STRING . "(80) NOT NULL",
            'created_at' => Schema::TYPE_DATETIME . " NULL",
            'updated_at' => Schema::TYPE_DATETIME . " NULL",
            'created_by' => Schema::TYPE_INTEGER . "(11) NOT NULL",
            'updated_by' => Schema::TYPE_INTEGER . "(11) NOT NULL",
        ], $this->tableOptions);

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
            'username' => Schema::TYPE_STRING . "(255) NOT NULL ",
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



        // fk: perfil
        $this->addForeignKey('fk_perfil_genero_id', '{{%perfil}}', 'genero_id', '{{%genero}}', 'id','RESTRICT','CASCADE'); // $delete= 'RESTRICT' $update='CASCADE'

    }

    public function down()
    {
        $this->dropForeignKey('fk_perfil_genero_id', '{{%perfil}}');
        $this->dropTable('{{%estado}}');
        $this->truncateTable('{{%perfil}}');
        $this->dropTable('{{%perfil}}'); // fk: genero_id
        $this->dropTable('{{%genero}}');
        $this->dropTable('{{%rol}}');
        $this->dropTable('{{%tipo_usuario}}');
        $this->dropTable('{{%user}}');
    }
}
