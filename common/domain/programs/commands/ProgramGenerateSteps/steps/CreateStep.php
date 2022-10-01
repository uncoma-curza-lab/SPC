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
        //obtener el id del director
        if ($model->load(Yii::$app->request->post())) {
            if($model->save()) {
                return  new ProgramStepResult(true, 'El programa se creó correctamente', [], $model);
                //Yii::$app->session->setFlash('warning','El programa se creó correctamente. <br>Complete el programa');
                //$this->mensajeGuardadoExito($model);
                //return $this->redirect(['cargar', 'id' => $model->id]);
            } else {
                return new ProgramStepResult(false, 'Hubo un problema al crear el programa', [], $model);
                //Yii::$app->session->setFlash('danger','Hubo un problema al crear el programa');
                //$this->mensajeGuardadoFalla($model);
            }
        } else {
              $model->year= date('Y');
        }

        return new ProgramStepResult(false, '', [], $model);
    }
}
