<?php

namespace common\domain\programs\commands\ProgramGenerateSteps\steps;

use common\domain\programs\commands\ProgramGenerateSteps\ProgramStepResult;
use common\domain\programs\commands\ProgramGenerateSteps\StepInterface;
use common\models\PermisosHelpers;
use common\models\Programa;
use Yii;
use yii\web\ForbiddenHttpException;

class GenericStep extends StepInterface
{
    private $program;
    private $scenario;

    function __construct(Programa $program, string $scenario)
    {
        $this->program = $program;
        $this->scenario = $scenario;
    }

    function handle(): ProgramStepResult
    {
        if (!parent::validatePermission() || !PermisosHelpers::requerirSerDueno($this->program->id)) {
            throw new ForbiddenHttpException('No tiene permisos para actualizar este elemento');
        }

        $this->program->scenario = $this->scenario;
        if ($this->program->load(Yii::$app->request->post())) {
            if($this->program->save()) {
                return  new ProgramStepResult(true, 'El programa se guardó', [], $this->program);
            } else {
                return new ProgramStepResult(false, 'Hubo un problema al crear el programa', [], $this->program);
            }
        }
        return new ProgramStepResult(false, '', [], $this->program);
    }
}
