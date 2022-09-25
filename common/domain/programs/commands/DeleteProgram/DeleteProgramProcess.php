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
            if (!$this->program->status->descriptionIs(Status::BORRADOR) || !PermisosHelpers::requerirSerDueno($userId)) {
                return new DeleteProgramResult(false, 'No tiene permisos para realizar esta operación', []);
            }

            $command = new DeleteAllNotificationsByProgramProcess($this->program);
            $result = $command->handle();

            if (!$result->getResult()) {
                throw new Exception('No se pudieron eliminar las notificaciones');
            }

            //delete notifications
            //if ($notifEmail = $this->program->getNotificationEmail()->all()) {
            //  foreach ($notifEmail as $notificacion) {
            //    $notifID = $notificacion->id;
            //    if($notificacion->delete()){
            //      Yii::info("Se eliminó la notificacion".$notifID." por la acción de borrar programa: ".$id,'- miprograma');
            //    } else {
            //      $flag = false;
            //      break;
            //      $transaccion->rollBack();
            //    }
            //  }
            //}
            //

            //delete panel notifications
            //if ($notifPanel = $model->getNotificationPanel()->all()) {
            //  foreach ($notifPanel as $notificacion) {
            //    $notifID = $notificacion->id;
            //    if($notificacion->delete()){
            //      Yii::info("Se eliminó la notificacion".$notifID." por la acción de borrar programa: ".$id,'- miprograma');
            //    } else {
            //      $flag = false;
            //      break;
            //      $transaccion->rollBack();
            //    }
            //  }
            //}
            //
            //


            $command = new DeleteAllObservationsByProgramProcess($this->program);
            $result = $command->handle();
            if (!$result->getResult()) {
                throw new Exception('No se pudieron eliminar las observaciones');
            }
            //delete observations
            //if($observaciones = $model->getObservaciones()->all()){
            //  foreach ($observaciones as $obs) {
            //    $obsId = $obs->id;
            //    if($obs->delete()) {
            //      Yii::info("Se eliminó la observación".$obsId." por la acción de borrar programa: ".$id,'- miprograma');
            //    } else {
            //      $flag = false;
            //      break;
            //      $transaccion->rollBack();
            //    }
            //  }
            //}
            

            if ($this->program->delete()) {
                $transaccion->commit();
                return new DeleteProgramResult(true, 'Se eliminó el programa con éxito', []);
            }
            throw new Exception('No se pudo eliminar el programa');
            // delete program
            //if ($flag && $model->delete()){
            //  $transaccion->commit();
            //  Yii::$app->session->setFlash('success','El programa eliminó correctamente.');
            //  Yii::info("Eliminó el programa: ".$id,'miprograma');
            //} else {
            //  $transaccion->rollBack();
            //  Yii::$app->session->setFlash('danger','El programa no se pudo eliminar.');
            //  Yii::error("No se pudo eliminar el programa: ".$id,'miprograma');
            //}
        } catch(Exception $e) {
          $transaccion->rollBack();
          return new DeleteProgramResult(false, $e->getMessage(), [ 'exception' => $e ]);
        }
    }

}
