<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "unidad".
 *
 * @property int $id
 * @property string $descripcion
 * @property int $programa_id
 *
 * @property Tema[] $temas
 * @property Programa $programa
 */
class Unidad extends \yii\db\ActiveRecord
{
  public $temas;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'unidad';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['descripcion'], 'required'],
            [['programa_id'], 'integer'],
            [['descripcion'], 'string', 'max' => 255],
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
            'descripcion' => 'Descripcion',
            'programa_id' => 'Programa ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTemas()
    {
        return $this->hasMany(Tema::className(), ['unidad_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPrograma()
    {
        return $this->hasOne(Programa::className(), ['id' => 'programa_id']);
    }
}
