<?php

namespace common\domain\observations\commands\DeleteObservation;

use common\models\Notification;
use common\models\PermisosHelpers;
use common\models\Programa as Program;
use common\models\Status;
use Exception;
use common\shared\commands\CommandInterface;
use Yii;

class DeleteAllObservationsByProgramProcess implements CommandInterface
{
    protected Program $program;

    public function __construct(Program $program)
    {
        $this->program = $program;
    }

    public function handle() : DeleteObservationResult
    {
        try {
            DeleteObservation::deleteAll([
                'program_id' => $this->program->id
            ]);

            return new DeleteObservationResult(true, 'Las observaciones fueron eliminadas con éxito', []);
        } catch (\Throwable $e) {
            return new DeleteObservationResult(false, 'Hubo un error al eliminar alguna observación', ['exception' => $e]);
        }
    }
