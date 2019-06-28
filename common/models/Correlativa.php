<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "objetivo".
 *
 * @property string $descripcion
 *
 * @property Programa $programa
 */
class Correlativa extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'correlativa';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['asignatura_id', 'correlativa_id'], 'integer'],
            [['asignatura_id'], 'required'],
            [['asignatura_id'], 'exist', 'skipOnError' => true, 'targetClass' => Asignatura::className(), 'targetAttribute' => ['asignatura_id' => 'id']],
            [['correlativa_id'], 'exist', 'skipOnError' => true, 'targetClass' => Asignatura::className(), 'targetAttribute' => ['correlativa_id' => 'id']],
        ];
    }

    public function attributeLabels()
    {
        return [
            'asignatura_id' => 'Asginatura ID',
            'correlativa_id' => 'Correlativa ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAsignatura()
    {
        return $this->hasOne(Asignatura::className(), ['id' => 'asignatura_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCorrelativa()
    {
        return $this->hasOne(Asignatura::className(), ['id' => 'correlativa_id']);
    }
}
