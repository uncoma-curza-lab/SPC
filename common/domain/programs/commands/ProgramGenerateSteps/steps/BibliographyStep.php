<?php

namespace common\domain\programs\commands\ProgramGenerateSteps\steps;

use common\domain\programs\commands\ProgramGenerateSteps\ProgramStepResult;
use common\domain\programs\commands\ProgramGenerateSteps\StepInterface;
use common\models\PermisosHelpers;
use common\models\Programa;
use Yii;
use yii\web\ForbiddenHttpException;

class BibliographyStep extends StepInterface
{
    private $program;

    function __construct(Programa $program)
    {
        $this->program = $program;
    }

    function handle(): ProgramStepResult
    {
        if (!parent::validatePermission() || !PermisosHelpers::requerirSerDueno($this->program->id)) {
            throw new ForbiddenHttpException('No tiene permisos para actualizar este elemento');
        }
        $this->program->scenario = 'bibliografia';
        if ($this->program->biblio_basica == null) {
            $this->program->biblio_basica = "<p><strong>Bibliograf&iacute;a b&aacute;sica</strong></p> <p>&nbsp;</p><p><strong>Bibliograf&iacute;a de consulta</strong></p>";
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
