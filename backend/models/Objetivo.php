<?php

namespace backend\models;

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
class Objetivo extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'objetivo';
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
    public function getPrograma()
    {
        return $this->hasOne(Programa::className(), ['id' => 'programa_id']);
    }
}
