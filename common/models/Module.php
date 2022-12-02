<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "modules".
 *
 * @property int $id
 * @property string $value
 * @property int $program_id
 * @property string $type
 *
 * @property Programa $program
 * @property Review[] $reviews
 * @property TimeDistribution[] $timeDistributions
 */
class Module extends \yii\db\ActiveRecord
{
    const TIME_DISTRIBUTION_TYPE = 'time_distribution';
    const FUNDAMENTALS_TYPE = 'fundamentals';
    const PLAN_OBJECTIVE_TYPE = 'plan_objetive';

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
            [['value'], 'string'],
            [['type'], 'string', 'max' => 255],
            [['program_id'], 'exist', 'skipOnError' => true, 'targetClass' => Programa::class, 'targetAttribute' => ['program_id' => 'id']],
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
            'type' => 'Tipo de modulo',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProgram()
    {
        return $this->hasOne(Programa::class, ['id' => 'program_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getReviews()
    {
        return $this->hasMany(Review::class, ['module_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTimeDistributions()
    {
        return $this->hasMany(TimeDistribution::class, ['module_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return ModulesQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ModulesQuery(get_called_class());
    }

    public function isSpecialModule()
    {
        return [
            self::TIME_DISTRIBUTION_TYPE,
        ];
    }

    public function clearModule()
    {
        if ($this->isSpecialModule()) {
            switch($this->type) {
                case self::TIME_DISTRIBUTION_TYPE:
                    TimeDistribution::deleteAll(['module_id' => $this->id]);
                    break;
            }

        }
    }

    public static function isModuleType(string $type) : bool
    {
        return in_array($type, [
            self::TIME_DISTRIBUTION_TYPE,
            self::FUNDAMENTALS_TYPE,
            self::PLAN_OBJECTIVE_TYPE,
        ]);
    }

}
