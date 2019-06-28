<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "plan".
 *
 * @property int $id
 * @property string $planordenanza
 * @property int $carrera_id
 *
 * @property Asignatura[] $asignaturas
 * @property Carrera $carrera
 */
class CarreraModalidad extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'carreramodalidad';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['carrera_id','modalidad_id'], 'required'],
            [['carrera_id','modalidad_id'], 'integer'],
            [['carrera_id'], 'exist', 'skipOnError' => true, 'targetClass' => Carrera::className(), 'targetAttribute' => ['carrera_id' => 'id']],
            [['modalidad_id'], 'exist', 'skipOnError' => true, 'targetClass' => Modalidad::className(), 'targetAttribute' => ['modalidad_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'modalidad_id' => 'Modalidad',
            'carrera_id' => 'Carrera',
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
    public function getModalidad()
    {
        return $this->hasOne(Modalidad::className(), ['id' => 'modalidad_id']);
    }
}
