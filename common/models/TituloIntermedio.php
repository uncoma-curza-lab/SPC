<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "plan".
 *
 * @property int $id
 * @property int $carrera_id
 *
 * @property Carrera $carrera
 */
class TituloIntermedio extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'titulo_intermedio';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['titulo_intermedio_id','carrera_id'], 'required'],
            [['titulo_intermedio_id','carrera_id'], 'integer'],
            [['carrera_id','titulo_intermedio_id'], 'exist', 'skipOnError' => true, 'targetClass' => Carrera::className(), 'targetAttribute' => ['carrera_id' => 'id' , 'titulo_intermedio_id' => 'id' ]],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'titulo_intermedio_id' => 'Titulo Intermedio',
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
    public function getTituloIntermedio()
    {
        return $this->hasOne(Carrera::className(), ['id' => 'titulo_intermedio_id']);
    }

    public function getTituloIntermedioSlug() {
        return $this->titulo_intermedio;
    }
    public function getCarreraSlug(){
        return $this->carrera_id;
    }
}
