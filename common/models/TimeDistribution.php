<?php

namespace common\models;

use Throwable;
use Yii;

/**
 * This is the model class for table "time_distribution".
 *
 * @property int $id
 * @property int $module_id
 * @property int $lesson_type_id
 * @property int $percentage_quantity
 *
 * @property LessonType $lessonType
 * @property Module $module
 */
class TimeDistribution extends \yii\db\ActiveRecord
{
    const MODULE_NAME = 'time_distribution';
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'time_distribution';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['module_id', 'lesson_type_id'], 'required'],
            [['module_id', 'lesson_type_id'], 'integer'],
            [['percentage_quantity'], 'number'],
            [['lesson_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => LessonType::class, 'targetAttribute' => ['lesson_type_id' => 'id']],
            [['module_id'], 'exist', 'skipOnError' => true, 'targetClass' => Module::class, 'targetAttribute' => ['module_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'module_id' => 'Module ID',
            'lesson_type_id' => 'Lesson Type ID',
            'percentage_quantity' => 'Percentage Quantity',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLessonType()
    {
        return $this->hasOne(LessonType::class, ['id' => 'lesson_type_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getModule()
    {
        return $this->hasOne(Module::class, ['id' => 'module_id']);
    }

    /**
     * {@inheritdoc}
     * @return TimeDistributionQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new TimeDistributionQuery(get_called_class());
    }

    public function getInHours(): float
    {
        try {
            $course = $this->module->program->asignatura;
            $weekHours = $course->carga_horaria_sem;
            return round($weekHours * $this->percentage_quantity / 100, 2);
        } catch (Throwable $e) {
            return 0;
        }
    }
}
