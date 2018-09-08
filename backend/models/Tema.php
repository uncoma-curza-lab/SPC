<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "tema".
 *
 * @property int $id
 * @property string $descripcion
 * @property int $unidad_id
 *
 * @property Unidad $unidad
 */
class Tema extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tema';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['descripcion'], 'required'],
            [['unidad_id'], 'integer'],
            [['descripcion'], 'string', 'max' => 255],
            [['unidad_id'], 'exist', 'skipOnError' => true, 'targetClass' => Unidad::className(), 'targetAttribute' => ['unidad_id' => 'id']],
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
            'unidad_id' => 'Unidad ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUnidad()
    {
        return $this->hasOne(Unidad::className(), ['id' => 'unidad_id']);
    }
}
