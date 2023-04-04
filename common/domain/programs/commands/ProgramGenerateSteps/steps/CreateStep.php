<?php

namespace common\domain\programs\commands\ProgramGenerateSteps\steps;

use common\domain\programs\commands\ProgramGenerateSteps\ProgramStepResult;
use common\domain\programs\commands\ProgramGenerateSteps\StepInterface;
use common\models\Programa;
use Yii;
use yii\web\ForbiddenHttpException;

class CreateStep extends StepInterface
{
    function handle(): ProgramStepResult
    {
        if (!parent::validatePermission()) {
            throw new ForbiddenHttpException('No tiene permisos para actualizar este elemento');
        }
        $model = Programa::initNewProgram();
        if ($model->load(Yii::$app->request->post())) {
            if($model->save()) {
                return  new ProgramStepResult(true, 'El programa se creó correctamente', [], $model);
            } else {
                return new ProgramStepResult(false, 'Hubo un problema al crear el programa', [], $model);
            }
        } else {
            $dateMonth = date('m');
            $model->year= date('Y');
            if ($dateMonth > 10) {
                $model->year= $model->year + 1;
            }
        }

        return new ProgramStepResult(false, '', [], $model);
    }
}
