<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "cargo".
 *
 * @property int $id
 * @property int $nomenclatura
 * @property int $nomenclatura
 *
 * @property Designacion[] $designacions
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
            [['carga_programa'], 'integer'],
             [['nomenclatura'], 'string', 'max' => 255],
             [['carga_programa'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nomenclatura' => 'Nomenclatura',
            'carga_programa' => 'Carga Programa',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDesignacions()
    {
        return $this->hasMany(Designacion::className(), ['cargo_id' => 'id']);
    }
}
