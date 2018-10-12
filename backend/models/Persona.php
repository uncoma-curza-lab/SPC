<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "persona".
 *
 * @property int $id
 * @property string $nombre
 * @property string $apellido
 * @property string $telefono
 * @property string $direccion
 * @property string $email
 * @property string $cuit
 */
class Persona extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'persona';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nombre', 'apellido', 'telefono', 'direccion', 'email', 'cuit'], 'required'],
            [['nombre', 'apellido'], 'string', 'max' => 60],
            [['telefono'], 'string', 'max' => 18],
            [['direccion', 'email'], 'string', 'max' => 80],
            [['cuit'], 'string', 'max' => 15],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nombre' => 'Nombre',
            'apellido' => 'Apellido',
            'telefono' => 'Telefono',
            'direccion' => 'Direccion',
            'email' => 'Email',
            'cuit' => 'Cuit',
        ];
    }
}
