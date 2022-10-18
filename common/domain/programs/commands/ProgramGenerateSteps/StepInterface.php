<?php

namespace common\domain\programs\commands\ProgramGenerateSteps;

use common\models\PermisosHelpers;
use common\shared\commands\CommandInterface;
use Yii;

abstract class StepInterface implements CommandInterface
{
    abstract function handle(): ProgramStepResult;

    function validatePermission()
    {
      if (!Yii::$app->user->isGuest) {
        //if (PermisosHelpers::requerirRol('Profesor') &&
        //  ($estado->descripcion == "Profesor") && ($model->created_by == $userId)) {
        /*if (PermisosHelpers::requerirRol('Profesor') &&
          ($estado->descripcion == "Profesor")) {
            return true;
        } else if (PermisosHelpers::requerirDirector($model->id) &&
          ($estado->descripcion == "Borrador")) {
              return true;
        }*/
        if(PermisosHelpers::requerirMinimoRol('Profesor') || PermisosHelpers::requerirMinimoRol('Admin') ){
          return true;
        }
      }
      return false;
    }
}

