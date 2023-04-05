<?php

namespace common\domain\programs\commands\ApproveProgram;

use common\models\PermisosHelpers;
use common\models\Programa as Program;
use common\models\Status;
use Exception;
use common\shared\commands\CommandInterface;

class CommandApproveProcess implements CommandInterface
{
  protected Program $program;

  public function __construct(Program $program)
  {
      $this->program = $program;
  }

  public function handle() : CommandApproveResult
  {
      $originalStatus = $this->program->status;
      try { 
          $draftFlow = $this->validateDraftFlow();


          if ($draftFlow) {
              $this->program->departamento_id = $this->program->asignatura->departamento_id;
          }

          if ($draftFlow || ($this->validateDepartmentFlow() && $this->validateAreas())) {

              $this->program->subirEstado();
              $this->program->save();

              $newStatus = $this->program->status;
              $message = "Subió el estado del programa de " . $originalStatus->descripcion . " a " . $newStatus->descripcion;

              return new CommandApproveResult(true, $message, [
                'originalStatus' => $originalStatus,
                'newStatus' => $newStatus 
              ]);
          }

          return new CommandApproveResult(false, 'No se pudo subir de estado', []);
      } catch (Exception $e) {
        return new CommandApproveResult(false, $e->getMessage(), [
          'error' => $e
        ]);
      }
  }

  private function validateDraftFlow() : bool
  {
      if ($this->program->status->descriptionIs(Status::BORRADOR)) {
        if(!$this->program->hasMinimumLoadPercentage()) {
          throw new Exception('No cumple el mínimo de porcentaje de carga');
        }
        if (!PermisosHelpers::requerirSerDueno($this->program->id)) {
          throw new Exception('No tiene permisos para eso');
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
      $this->program->status->descriptionIs(Status::EN_ESPERA) &&
      !PermisosHelpers::requerirSerDueno($this->program->id)
    ){
      throw new Exception('request program first');
    }

    return true;
  }

  private function validateAreas() : bool
  {
      $status = $this->program->status;
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
