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
    const PROGRAM_OBJECTIVE_TYPE = 'program_objective';
    const PLAN_CONTENT_TYPE = 'plan_content';
    const ANALYTICAL_CONTENT_TYPE = 'analytical_content';
    const BIBLIOGRAPHY_TYPE = 'bibliography';
    const METHOD_PROPOSAL_TYPE = 'method-proposal';
    const EVALUATION_AND_ACCREDITATION_TYPE = 'evaluation-accreditation';
    const EXAMS_AND_PROMOTION_TYPE = 'exams-promotion';
    const TIMELINE_TYPE = 'timeline';
    const ACTIVITIES_TYPE = 'activities';
    const SIGN_TYPE = 'sign';

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
            self::PROGRAM_OBJECTIVE_TYPE,
            self::PLAN_CONTENT_TYPE,
            self::ANALYTICAL_CONTENT_TYPE,
            self::BIBLIOGRAPHY_TYPE,
            self::METHOD_PROPOSAL_TYPE,
            self::EVALUATION_AND_ACCREDITATION_TYPE,
            self::EXAMS_AND_PROMOTION_TYPE,
            self::TIMELINE_TYPE,
            self::ACTIVITIES_TYPE,
            self::SIGN_TYPE
        ]);
    }

}
