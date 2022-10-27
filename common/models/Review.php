<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "reviews".
 *
 * @property int $id
 * @property int $program_id
 * @property string $area
 * @property int $observation_id
 * @property int $module_id
 * @property string $resolution
 *
 * @property Modules $module
 * @property Observacion $observation
 * @property Programa $program
 */
class Review extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'reviews';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['program_id', 'area'], 'required'],
            [['program_id', 'observation_id', 'module_id'], 'integer'],
            [['resolution'], 'string'],
            [['area'], 'string', 'max' => 255],
            [['module_id'], 'exist', 'skipOnError' => true, 'targetClass' => Module::className(), 'targetAttribute' => ['module_id' => 'id']],
            [['observation_id'], 'exist', 'skipOnError' => true, 'targetClass' => Observacion::className(), 'targetAttribute' => ['observation_id' => 'id']],
            [['program_id'], 'exist', 'skipOnError' => true, 'targetClass' => Programa::className(), 'targetAttribute' => ['program_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'program_id' => 'Program ID',
            'area' => 'Area',
            'observation_id' => 'Observation ID',
            'module_id' => 'Module ID',
            'resolution' => 'Resolution',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getModule()
    {
        return $this->hasOne(Module::className(), ['id' => 'module_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getObservation()
    {
        return $this->hasOne(Observacion::className(), ['id' => 'observation_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProgram()
    {
        return $this->hasOne(Programa::className(), ['id' => 'program_id']);
    }

    /**
     * {@inheritdoc}
     * @return ReviewQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ReviewQuery(get_called_class());
    }
}
