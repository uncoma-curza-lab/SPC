<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "status".
 *
 * @property int $id
 * @property string $descripcion
 *
 * @property Programa[] $programas
 */
class Status extends \yii\db\ActiveRecord
{
    const BORRADOR_ID = 1;
    const DEPARTAMENTO_ID = 2;
    const EN_ESPERA_ID = 3;
    const ADMINISTRACION_ACADEMICA_ID = 4;
    const SECRETARIA_ACADEMICA_ID = 5;
    const BIBLIOTECA_ID = 6;

    const BORRADOR = 'Borrador';
    const DEPARTAMENTO = 'Departamento';
    const EN_ESPERA = 'En espera';
    const ADMINISTRACION_ACADEMICA = 'Administración Académica';
    const SECRETARIA_ACADEMICA = 'Secretaría Académica';
    const BIBLIOTECA = 'Biblioteca';

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'status';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['descripcion'], 'required'],
            [['value'], 'integer'],
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
            'value' => 'Valor',
            'descripcion' => 'Descripcion',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProgramas()
    {
        return $this->hasMany(Programa::className(), ['status_id' => 'id']);
    }

    public function getDescripcion(){
      $descripcion = $this->descripcion;
      return $descripcion;
    }

    public function prevStatus()
    {
        return Status::find()->where(['<','value',$this->value])
                                           ->orderBy('value DESC')
                                           ->one();
    }

    public function nextStatus()
    {
        return Status::find()->where(['>','value',$this->value])
                                           ->orderBy('value')
                                           ->one();
    }

    public static function initialStatus()
    {
        return Status::find()->where([
          '=',
          'descripcion',
          'Borrador'
        ])->one()->id;
    }

    public function descriptionIs($statusDescription): bool
    {
        return $this->descripcion === $statusDescription;
    }

    public function is(int $id): bool
    {
        return $this->id === $id;
    }
}
