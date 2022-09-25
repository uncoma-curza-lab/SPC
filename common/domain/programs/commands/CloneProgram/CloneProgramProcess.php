<?php

namespace common\domain\programs\commands\CloneProgram;

use common\models\PermisosHelpers;
use common\models\Programa as Program;
use common\models\Status;
use Exception;
use common\shared\commands\CommandInterface;
use Yii;

class CloneProgramProcess implements CommandInterface
{
    protected Program $program;

    public function __construct(Program $program)
    {
        $this->program = $program;
    }

    public function handle() : CloneProgramResult
    {
        try {
            if (!$this->validate()) {
                throw new Exception('No tiene permisos para clonar el programa');
            }
            $modelNew = clone $this->program;
            $modelNew->scenario = 'copy';
            $modelNew->status_id = Status::find()->where(['=','descripcion','Borrador'])->one()->id;
            $modelNew->isNewRecord = true;
            $modelNew->id = null;
            $modelNew->departamento_id = null;
            // TODO Borrar firma y equipo de catedra
            $modelNew->setAsignatura('null');
            if (!$modelNew->save()) {
                throw new Exception('No se pudo guardar la copia');
            }
            return new CloneProgramResult(true, 'El programa fue clonado con éxito', [
                'new_program' => $modelNew
            ]);
        } catch (\Throwable $e) {
            return new CloneProgramResult(false, 'No se pudo clonar el programa', ['exception' => $e]);
        }
    }

    protected function validate()
    {
        if (Yii::$app->user->isGuest) {
          return false;
        }

        $userId = \Yii::$app->user->identity->id;

        $isOwnerTeacher = PermisosHelpers::requerirMinimoRol('Profesor') && $userId == $this->program->created_by;
        $isAdmin = PermisosHelpers::requerirMinimoRol('Admin');

        if ($isOwnerTeacher || $isAdmin) {
            return true;
        }

        return false;
    }
}
