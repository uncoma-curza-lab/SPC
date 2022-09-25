<?php

namespace common\domain\programs\commands\DeleteProgram;

use common\domain\notifications\commands\DeleteNotification\DeleteAllNotificationsByProgramProcess;
use common\domain\observations\commands\DeleteObservation\DeleteAllObservationsByProgramProcess;
use common\models\PermisosHelpers;
use common\models\Programa as Program;
use common\models\Status;
use Exception;
use common\shared\commands\CommandInterface;
use Yii;

class DeleteProgramProcess implements CommandInterface
{
    protected Program $program;

    public function __construct(Program $program)
    {
        $this->program = $program;
    }

    public function handle() : DeleteProgramResult
    {
        $userId = \Yii::$app->user->identity->id;
        $transaccion = Yii::$app->db->beginTransaction();
        try {
            // si está en borrador y es dueño
            if (!$this->program->status->descriptionIs(Status::BORRADOR) || !PermisosHelpers::requerirSerDueno($this->program->id)) {
                return new DeleteProgramResult(false, 'No tiene permisos para realizar esta operación', []);
            }

            $command = new DeleteAllNotificationsByProgramProcess($this->program);
            $result = $command->handle();

            if (!$result->getResult()) {
                throw new Exception('No se pudieron eliminar las notificaciones');
            }

            $command = new DeleteAllObservationsByProgramProcess($this->program);
            $result = $command->handle();
            if (!$result->getResult()) {
                throw new Exception('No se pudieron eliminar las observaciones');
            }

            if ($this->program->delete()) {
                $transaccion->commit();
                return new DeleteProgramResult(true, 'Se eliminó el programa con éxito', []);
            }
            throw new Exception('No se pudo eliminar el programa');

        } catch(Exception $e) {
            $transaccion->rollBack();
            return new DeleteProgramResult(false, $e->getMessage(), [ 'exception' => $e ]);
        }
    }

}
