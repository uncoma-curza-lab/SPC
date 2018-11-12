<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "cargo".
 *
 * @property int $id
 * @property string $designacion
 * @property int $programa_id
 *
 * @property Programa $programa
 */
class Cargo extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'cargo';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nombre_persona','designacion'], 'required'],
            [[ 'programa_id'], 'integer'],
            [['designacion'], 'string', 'max' => 255],
            [['nombre_persona'],'string','max' => 100],
            [['programa_id'], 'exist', 'skipOnError' => true, 'targetClass' => Programa::className(), 'targetAttribute' => ['programa_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'designacion' => 'Designacion',
            'nombre_persona' => 'Nombre y apellido',
            'programa_id' => 'Programa ID',
        ];
    }


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPrograma()
    {
        return $this->hasOne(Programa::className(), ['id' => 'programa_id']);
    }
}
