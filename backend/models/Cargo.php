<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "cargo".
 *
 * @property int $id
 * @property string $designacion
 * @property int $persona_id
 * @property int $programa_id
 *
 * @property Persona $persona
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
            [['designacion'], 'required'],
            [['persona_id', 'programa_id'], 'integer'],
            [['designacion'], 'string', 'max' => 255],
            [['persona_id'], 'exist', 'skipOnError' => true, 'targetClass' => Persona::className(), 'targetAttribute' => ['persona_id' => 'id']],
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
            'persona_id' => 'Persona ID',
            'programa_id' => 'Programa ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPersona()
    {
        return $this->hasOne(Persona::className(), ['id' => 'persona_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPrograma()
    {
        return $this->hasOne(Programa::className(), ['id' => 'programa_id']);
    }
}
