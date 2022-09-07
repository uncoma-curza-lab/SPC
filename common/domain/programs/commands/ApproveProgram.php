<?php

namespace common\shares\commands;

use common\domain\programs\commands\ApproveCommandResult;
use common\models\PermisosHelpers;
use common\models\Programa as Program;
use common\models\Status;
use Exception;
use common\shared\commands\CommandExecutionResult;
use common\shared\commands\CommandInterface;

class ApproveProgram implements CommandInterface
{
  protected Program $program;

  public function __construct(Program $program)
  {
      $this->program = $program;
  }

  public function handle() : CommandExecutionResult
  {
      $originalStatus = $this->program->getStatus();
      try { 
          if ($this->validateDraftFlow() || ($this->validateDepartmentFlow() && $this->validateAreas())) {

              $this->program->subirEstado();
              $this->program->save();

              $newStatus = $this->program->getStatus();
              $message = "Subió el estado del programa de " . $originalStatus->descripcion . " a " . $newStatus->descripcion;

              return new ApproveCommandResult(true, $message, [
                'originalStatus' => $originalStatus,
                'newStatus' => $newStatus 
              ]);
          }

          return new ApproveCommandResult(false, 'No se pudo subir de estado', []);
      } catch (Exception $e) {
        return new ApproveCommandResult(false, 'No se cumple con los requisitos para subir de estado', [
          'error' => $e
        ]);
      }
  }

  private function validateDraftFlow() : bool
  {
      if ($this->program->getStatus()->descriptionIs(Status::BORRADOR)) {
        if(!$this->program->hasMinimumLoadPercentage() || !PermisosHelpers::requerirSerDueno($this->program->id)) {
          throw new Exception('');
        }
        return true;
      }
      return false;

  }

  private function validateDepartmentFlow() : bool
  {
     // department flow -- require request program first
    if (
      PermisosHelpers::requerirRol("Departamento") &&
      $this->program->getStatus()->descriptionIs(Status::EN_ESPERA) &&
      !PermisosHelpers::requerirSerDueno($this->program->id)
    ){
      throw new Exception('request program first');
    }

    return true;
  }

  private function validateAreas() : bool
  {
      $status = $this->program->getStatus();
      if(
          (PermisosHelpers::requerirDirector($this->program->id) && ($status->descriptionIs(Status::DEPARTAMENTO))) ||
          (PermisosHelpers::requerirRol("Adm_academica") && $status->descriptionIs(Status::ADMINISTRACION_ACADEMICA)) ||
          (PermisosHelpers::requerirRol("Sec_academica") && $status->descriptionIs(Status::SECRETARIA_ACADEMICA))
       ){
         return true;
       }

      return false;
  }
}
