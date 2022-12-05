<?php

namespace common\domain\programs\commands\GetCompleteProgram;

use common\models\Programa;
use common\shared\commands\CommandInterface;
use yii\web\NotFoundHttpException;

class GetCompleteProgramCommand implements CommandInterface
{
    protected int $programId;

    public function __construct(int $programId, string $moduleType = "default")
    {
        $this->programId = $programId;
        $this->moduleType = $moduleType;

    }

    public function handle() : GetCompleteProgramResult
    {
        try {
            $program = Programa::find()->where([
                '=', 'id', $this->programId
            ])->with([
               'modules',
               'modules.timeDistributions'
            ])->one();

            if (!$program) {
                throw new NotFoundHttpException('El programa no pudo encontrarse');
            }

            $program->defineScenario($this->moduleType);

            return new GetCompleteProgramResult(
                true,
                'Programa encontrado con éxito',
                [ 'program' => $program]
            );
        } catch (\Throwable $e) {
            return new GetCompleteProgramResult(
                false,
                'Hubo un problema al encontrar el programa',
                ['exception' => $e]
            );
        }
    }
}
