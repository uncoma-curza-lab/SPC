<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "objetivo".
 *
 * @property int $id
 * @property string $descripcion
 * @property int $programa_id
 *
 * @property Programa $programa
 */
class Modalidad extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'modalidad';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nombre'], 'required'],
            [['descripcion'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'descripcion' => 'Descripcion',
            'nombre' => 'Nombre',
        ];
    }
    public function getDescripcion(){
      return $this->descripcion;
    }
    
    public function getNombre()
    {
        return $this->nombre;
    }
}
