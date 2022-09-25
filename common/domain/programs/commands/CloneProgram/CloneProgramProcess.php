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
        $modelNew = null;
        $message = '';
        $statusResponse = false;
        $dataResponse = [];
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
            $dataResponse['new_program'] = $modelNew;
            if (Yii::$app->request->post() && $modelNew->load(Yii::$app->request->post()) && $modelNew->save()) {
                $message = 'El programa se clonó con éxito';
                $statusResponse = true;
            }
        } catch (\Throwable $e) {
            $statusResponse = false;
            $message = $e->getMessage();
            $dataResponse['exception'] = $e;
        } finally {
            return new CloneProgramResult($statusResponse, $message, $dataResponse);

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
