<?php

namespace frontend\models;

use common\domain\programs\commands\CreateNewProgram\CreateNewProgramCommand;
use common\domain\TimeDistribution\commands\CreateNewTimeDistribution\NewTimeDistributionCommand;
use common\models\LessonType as ModelsLessonType;
use common\models\Module;
use common\models\Programa;
use common\models\TimeDistribution;
use Exception;
use yii\base\Model;

class TimeDistributionCreationForm extends Model
{
    public Programa $program;
    public $lesson_types;
    public Module $module;

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
        ];
    }


    public function loadData(array $data): void
    {
        $this->validations($data);
        $program = $data['Programa'];
        $createProgramCommand = new CreateNewProgramCommand($program['asignatura_id'], $program['year']);
        $resultNewProgram = $createProgramCommand->handle();
        if(!$resultNewProgram->getResult()) {
            // throw error
            return;
        }
        $program = $resultNewProgram->getResult()['model'];

        $module = new Module();

        $module->program_id = $program->id;
        $module->save();

        $distributionSchema = $data['TimeDistributionCreationForm']['lesson_type'];


        $totalHours = $program->asignatura->carga_horaria_sem;
        $totalUsed = 0;

        $distributions = [];
        // move to create bulk
        foreach($distributionSchema as $lessonTypeDistribution) {
            $lessonTypeId = $lessonTypeDistribution['lesson_type'];
            $lessonType = ModelsLessonType::findOne($lessonTypeId);
            $hours = $lessonTypeDistribution['lesson_type_hours'];
            if ($hours > ($lessonType->max_use_percentage * $totalHours / 100)) {
                throw new Exception("Max Percentage Limit");
            }
            $totalUsed += $hours;
            $usePercentage = $hours * $lessonType->max_use_percentage / 100;
            $distribution = new TimeDistribution();
            $distribution->module_id = $module->id;
            $distribution->program_id = $program->id;
            $distribution->lesson_type_id = $lessonTypeId;
            $distribution->percentage_quantity = $usePercentage;

            $distributions[] = $distribution;
        }

        if ($totalUsed != $totalHours) {
            throw new Exception('not used 100%');
        }

        //$command = new NewTimeDistributionCommand((int) $program->id, 1231, $data['TimeDistributionCreationForm']);

    }

    private function validations(array $data)
    {
        /// TODO throws
        if (!array_key_exists('Programa', $data) || !array_key_exists('TimeDistributionCreationForm', $data)) {
            return false;
        }

        $program = $data['Programa'];

        if (!array_key_exists('year', $program) && $program['year'] < 2022) {
            return false;
        }

        if (!array_key_exists('asignatura_id', $program)) {
            return false;
        }

        $timeDistribution = $data['TimeDistributionCreationForm'];

        if (!array_key_exists('lesson_type', $timeDistribution)) {
            return false;
        }

        $distributionSchema = $timeDistribution['lesson_type'];
        if (!count($distributionSchema)) {
            return false;
        }
    }
}
