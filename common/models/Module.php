<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "modules".
 *
 * @property int $id
 * @property string $value
 * @property int $program_id
 *
 * @property Programa $program
 * @property Reviews[] $reviews
 * @property TimeDistribution[] $timeDistributions
 */
class Module extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'modules';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['value'], 'required'],
            [['program_id'], 'integer'],
            [['value'], 'string', 'max' => 255],
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
            'value' => 'Value',
            'program_id' => 'Program ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProgram()
    {
        return $this->hasOne(Programa::className(), ['id' => 'program_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getReviews()
    {
        return $this->hasMany(Reviews::className(), ['module_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTimeDistributions()
    {
        return $this->hasMany(TimeDistribution::className(), ['module_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return ModulesQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ModulesQuery(get_called_class());
    }
}
