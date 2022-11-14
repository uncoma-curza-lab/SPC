<?php

namespace common\domain\programs\commands\CreateNewProgram;

use common\models\Asignatura;
use common\models\Programa;
use common\shared\commands\CommandInterface;
use Exception;

class CreateNewProgramCommand implements CommandInterface
{
    protected int $courseId;
    protected int $year;

    public function __construct(int $courseId, int $year)
    {
        $this->courseId = $courseId;
        $this->year = $year;
    }

    public function handle(): CreateNewProgramResult
    {
        try {

            $model = Programa::initNewProgram();
            $course = Asignatura::findOne($this->courseId);
            if (!$course) {
                throw new Exception("No se encuentra la asignatura");
            }

            $model->setAsignatura($course->id);
            $model->year = $this->year;
            if (!$model->save()) {
                throw new Exception('Error save program');
            }
            return new CreateNewProgramResult(
                true,
                "Se creó el programa correctamente",
                [
                    'model' => $model,
                ]
            );
        } catch (\Throwable $e) {
            return new CreateNewProgramResult(
                false,
                "Hubo un error al intentar crear el programa.",
                [
                    'exception' => $e,
                    'exception_message' => $e->getMessage(),
                ]
            );

        }

    }
}
