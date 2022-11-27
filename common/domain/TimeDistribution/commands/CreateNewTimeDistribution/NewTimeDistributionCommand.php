<?php

namespace common\domain\TimeDistribution\commands\CreateNewTimeDistribution;

use common\models\LessonType;
use common\models\Module;
use common\models\Programa;
use common\models\TimeDistribution;
use common\shared\commands\CommandInterface;
use Exception;
use Yii;

class NewTimeDistributionCommand implements CommandInterface
{
    protected $module;
    protected $distributions;

    public function __construct(Module $module, array $distributions)
    {
        $this->module = $module;
        $this->distributions = $distributions;
    }

    public function handle() : NewTimeDistributionResult
    {
        $transaction = Yii::$app->db->beginTransaction();
        try {
            $program = $this->module->program;
            $totalHours = $program->asignatura->carga_horaria_sem;
            $totalUsed = 0;
            $distributions = [];

            foreach($this->distributions as $distribution) {
                if (
                    !is_array($distribution) ||
                    !array_key_exists('lesson_type_id', $distribution) ||
                    !is_numeric($distribution['lesson_type_id'])
                ) {
                    continue;
                }

                $lessonType = LessonType::findOne($distribution['lesson_type_id']);
                if (!$lessonType) {
                    throw new Exception('LessonType not found');
                }
                $maxHours = ($lessonType->max_use_percentage * $totalHours / 100);
                $hours = $distribution['lesson_type_hours'];
                if ($hours > $maxHours) {
                    throw new Exception("Max Percentage Limit hours: " . $hours . " > " . $maxHours);
                }
                $totalUsed += $hours;
                $usePercentage = round($hours * 100 / $totalHours, 2);
                $newDistributionTime = new TimeDistribution();
                $newDistributionTime->lesson_type_id = $lessonType->id;
                $newDistributionTime->module_id = $this->module->id;
                $newDistributionTime->percentage_quantity = $usePercentage;
                $distributions[] = $newDistributionTime;
                if (!$newDistributionTime->save()) { 
                    throw new Exception('TimeDistribution validation error');
                }
            }
            if (count($distributions) == 0) {
                throw new Exception('distributions empty');
            }

            if ($totalUsed != $totalHours) {
                throw new Exception('not used 100%');
            }
            $transaction->commit();
            return new NewTimeDistributionResult(true, 'Distribuciones horarias creadas', ['distributions' => $distribution]);
        } catch (\Throwable $e) {
            $transaction->rollBack();
            return new NewTimeDistributionResult(false, 'No se pudo crear modulo => Distribución horaria', ['exception' => $e]);
        }
    }
}
