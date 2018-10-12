<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "carreraprograma".
 *
 * @property int $id
 * @property int $carrera_id
 * @property int $programa_id
 *
 * @property Carrera $carrera
 * @property Programa $programa
 */
class CarreraPrograma extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'carreraprograma';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['carrera_id', 'programa_id'], 'integer'],
            [['carrera_id'], 'exist', 'skipOnError' => true, 'targetClass' => Carrera::className(), 'targetAttribute' => ['carrera_id' => 'id']],
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
            'carrera_id' => 'Carrera ID',
            'programa_id' => 'Programa ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCarrera()
    {
        return $this->hasOne(Carrera::className(), ['id' => 'carrera_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPrograma()
    {
        return $this->hasOne(Programa::className(), ['id' => 'programa_id']);
    }
}
