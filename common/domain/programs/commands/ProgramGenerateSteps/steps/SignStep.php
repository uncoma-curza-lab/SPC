<?php

namespace common\domain\programs\commands\ProgramGenerateSteps\steps;

use common\domain\programs\commands\ProgramGenerateSteps\ProgramStepResult;
use common\domain\programs\commands\ProgramGenerateSteps\StepInterface;
use common\models\Programa;
use Yii;

class SignStep extends StepInterface
{
    private $program;

    function __construct(Programa $program)
    {
        $this->program = $program;
    }

    function handle(): ProgramStepResult
    {
        $this->program->scenario = 'firma';
        if($this->program->getFirma() == null){
          $html =
              '<div class="" style="text-align: center;">Firma del responsable <br />Aclaraci&oacute;n <br />Cargo</div>
              <div class="" style="text-align: center;">&nbsp;</div>
              <div class="" style="text-align: center;"><br />
              <div class="" style="text-align: right;">Lugar y fecha de entrega</div>
              </div>';
          $this->program->setFirma($html);
        }
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
