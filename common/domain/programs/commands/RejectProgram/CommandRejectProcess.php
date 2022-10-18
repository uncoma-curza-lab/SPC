<?php

namespace common\domain\programs\commands\RejectProgram;

use common\models\PermisosHelpers;
use common\shared\commands\CommandInterface;
use common\models\Programa as Program;
use common\models\Status;

class CommandRejectProcess implements CommandInterface
{
    protected Program $program;

    public function __construct(Program $program)
    {
        $this->program = $program;
    }

    public function handle(): CommandRejectResult
    {
        try {
            $originalStatus = $this->program->status;
            if ($this->canSetFromAreas()) {
                $this->program->setEstado(Status::BORRADOR);
                $this->program->save();
                return new CommandRejectResult(
                    true,
                    "Cambió el estado de " . $originalStatus->descripcion . " -> Borrador, Identificador de programa: ".$this->program->id,
                    [
                        'original_status' => $originalStatus,
                        'new_status' => Status::BORRADOR,
                        'message' => 'Se rechazó el programa correctamente'
                    ]
                );
            }

            if ($this->isDraftStatus()) {
                // NO
                return new CommandRejectResult(
                    false,
                    "El estado del programa no es el indicado para ejecutar esta operación",
                    [
                        'original_status' => $originalStatus,
                    ]
                );
            }

            return new CommandRejectResult(
                false,
                "No se pudo cambiar el estado del programa. Verifique que posee para realizar el cambio",
                [
                    'original_status' => $originalStatus,
                ]
            );
        } catch (\Throwable $e) {
            return new CommandRejectResult(
                false,
                "Hubo un error al intentar rechazar el programa.",
                [
                    'original_status' => $originalStatus,
                    'exception' => $e,
                    'exception_message' => $e->getMessage(),
                ]
            );

        }

    }

    public function isDraftStatus(): bool
    {
        $originalStatus = $this->program->status;
        return $originalStatus->descriptionIs(Status::BORRADOR) || $originalStatus->descriptionIs(Status::EN_ESPERA);
    }

    public function canSetFromAreas(): bool
    {
        $originalStatus = $this->program->status;
        return (PermisosHelpers::requerirDirector($this->program->id) && $originalStatus->descriptionIs(Status::DEPARTAMENTO)) ||
            (PermisosHelpers::requerirRol("Adm_academica") && $originalStatus->descriptionIs(Status::ADMINISTRACION_ACADEMICA)) ||
            (PermisosHelpers::requerirRol("Sec_academica") && $originalStatus->descriptionIs(Status::SECRETARIA_ACADEMICA));
    }

}
