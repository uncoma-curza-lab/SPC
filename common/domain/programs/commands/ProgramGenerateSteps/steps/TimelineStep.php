<?php

namespace common\domain\programs\commands\ProgramGenerateSteps\steps;

use common\domain\programs\commands\ProgramGenerateSteps\ProgramStepResult;
use common\domain\programs\commands\ProgramGenerateSteps\StepInterface;
use common\models\Programa;
use Yii;

class TimelineStep extends StepInterface
{
    private $program;

    function __construct(Programa $program)
    {
        $this->program = $program;
    }

    function handle(): ProgramStepResult
    {
        $this->program->scenario = 'crono-tent';
        if ($this->program->crono_tentativo == null ) {
            $this->program->crono_tentativo = '
            <table style="border-collapse: collapse; height: 110px; border-color: black; border-style: solid; float: left;" border="1">
              <tbody>
              <tr style="height: 22px;">
              <th style="width: 400.2px; height: 22px;" colspan="5">Cuatrimestre</th>
              </tr>
              <tr style="height: 44px;">
              <th style="width: 106px; height: 44px;">Tiempo <br />/ Unidades</th>
              <th style="width: 68px; height: 44px;">Marzo</th>
              <th style="width: 53px; height: 44px;">Abril</th>
              <th style="width: 61px; height: 44px;">Mayo</th>
              <th style="width: 57px; height: 44px;">Junio</th>
              </tr>
              <tr style="height: 22px;">
              <td style="width: 106px; height: 22px;">Unidad 1</td>
              <td style="width: 68px; height: 22px;">X</td>
              <td style="width: 53px; height: 22px;">&nbsp;</td>
              <td style="width: 61px; height: 22px;">&nbsp;</td>
              <td style="width: 57px; height: 22px;">&nbsp;</td>
              </tr>
              <tr style="height: 22px;">
              <td style="width: 106px; height: 22px;">Unidad 2</td>
              <td style="width: 68px; height: 22px;">&nbsp;</td>
              <td style="width: 53px; height: 22px;">&nbsp;</td>
              <td style="width: 61px; height: 22px;">&nbsp;</td>
              <td style="width: 57px; height: 22px;">&nbsp;</td>
              </tr>
              </tbody>
              </table>
            ';
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
