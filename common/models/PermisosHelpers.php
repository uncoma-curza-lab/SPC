<?php
namespace common\models;
use common\models\ValorHelpers;
use yii;
use yii\web\Controller;
use yii\helpers\Url;
use common\models\Cargo;
use common\models\Programa;
use common\models\Departamento;
use common\models\Designacion;
use common\models\Perfil;
class PermisosHelpers
{
    /**
    * Verifica si ya existe un profesor adjunto al programa
    */
    public static function existeProfAdjunto($programaID){
      $programa = Programa::find()->where(['=','id',$programaID])->one();
      if (isset($programa)){
        $cargoProfAdj = Cargo::find()->where(['=','carga_programa',1])->one();
        $profAdjunto = $programa->getDesignaciones()->where(['=','cargo_id',$cargoProfAdj->id])->one();
        if (isset($profAdjunto) && $profAdjunto->cargo_id == $cargoProfAdj->id ){
          return true;
        } else {
          return false;
        }
      }
      return false;
    }
    /**
    * Verifica si el usuario logueado es el Profesor Adjunto del programa
    */
    public static function requerirProfesorAdjunto($programaID){
      $programa = Programa::find()->where(['=','id',$programaID])->one();
      if (isset($programa)){
          $cargoProfAdj = Cargo::find()->where(['=','carga_programa',1])->one();
          $designaciones = $programa->getDesignaciones();
          $profesor = $designaciones->where(['=','cargo_id',$cargoProfAdj->id])->one();
          $perfil = \Yii::$app->user->identity->perfil;
          if (isset($profesor) && isset($perfil) &&  $perfil->id == $profesor->perfil_id) {
            return true;
          } else {
            return false;
          }
      }
      return false;
    }
    /**
    * Verifica si el usuario logueado es director del departamento que
    * obtiene el programa
    */
    public static function requerirDirector($programaID){
      $programa = Programa::findOne($programaID);
      if (!PermisosHelpers::requerirRol("Departamento") && !$programa)
        return false;
      //si el programa tiene el departamento
      $departamento = $programa->getDepartamento()->one();

      //$departamento = $programa->getAsignatura()->one()->getDepartamento()->one();
      $cargo = Cargo::find()->where(['=','nomenclatura','Director'])->one();
      $perfil = \Yii::$app->user->identity->perfil;


      if($perfil)
        $designacion = Designacion::find()->where(['=','cargo_id',$cargo->id])
          ->andWhere(['=','perfil_id',$perfil->id])->one();
        // si el programa no tiene el dpto busco al que corresponda la designacion
      else {
        return false;
      }
      //antes buscaba por dpto de programa
      //$departamento = $programa->getDepartamento()->one();
      if($designacion && $departamento){
        if ($designacion->departamento_id == $departamento->id) {
          return true;
        } else {
          return false;
        }
      }
      return false;
    }
    public static function requerirSerDueno($programaID){
      $userID = \Yii::$app->user->identity->id;
      $programa = Programa::findOne($programaID);
      if($programa){
        return $programa->created_by == $userID ? true : false;
      }
    }

    public static function requerirUpgradeA($tipo_usuario_nombre)
    {
        if (!ValorHelpers::tipoUsuarioCoincide($tipo_usuario_nombre)) {
            return Yii::$app->getResponse()->redirect(Url::to(['upgrade/index']));
        }
    }

    public static function requerirEstado($estado_nombre)
    {
        return ValorHelpers::estadoCoincide($estado_nombre);
    }

    public static function requerirRol($rol_nombre)
    {
        return ValorHelpers::rolCoincide($rol_nombre);
    }

    public static function requerirMinimoRol($rol_nombre, $userId=null)
    {
        if (ValorHelpers::esRolNombreValido($rol_nombre)){
            if ($userId == null) {
                $userRolValor = ValorHelpers::getUsersRolValor();
            } else {
                $userRolValor = ValorHelpers::getUsersRolValor($userId);
            }
            return $userRolValor >= ValorHelpers::getRolValor($rol_nombre) ? true : false;
        } else {
            return false;
        }
    }

    public static function userDebeSerPropietario($model_nombre, $model_id)
    {
        $connection = \Yii::$app->db;
        $userid = Yii::$app->user->identity->id;
        $sql = "SELECT id FROM $model_nombre WHERE created_by=:userid AND id=:model_id";
        $command = $connection->createCommand($sql);
        $command->bindValue(":userid", $userid);
        $command->bindValue(":model_id", $model_id);
        if($result = $command->queryOne()) {
            return true;
        } else {
            return false;
        }
    }

    public static function puedeAprobar($programaID, $estadoActual)
    {
        return (
            PermisosHelpers::requerirProfesorAdjunto($programaID) && $estadoActual->descriptionIs(Status::EN_ESPERA)
          ) ||
          (
            PermisosHelpers::requerirDirector($programaID) && (
              $estadoActual->descriptionIs(Status::DEPARTAMENTO) || $estadoActual->descriptionIs(Status::BORRADOR))
          ) ||
          (
            PermisosHelpers::requerirRol("Adm_academica") && $estadoActual->descriptionIs(Status::ADMINISTRACION_ACADEMICA)
          ) ||
          (
            PermisosHelpers::requerirRol("Sec_academica") && $estadoActual->descriptionIs(Status::SECRETARIA_ACADEMICA)
          );
    }

    public static function puedeRechazar($programaID, $estadoActual)
    {
        return (
            PermisosHelpers::requerirProfesorAdjunto($programaID) && $estadoActual->descriptionIs(Status::EN_ESPERA)
          ) ||
          (
            PermisosHelpers::requerirDirector($programaID) && $estadoActual->descriptionIs(Status::DEPARTAMENTO)
          ) ||
          (
            PermisosHelpers::requerirRol("Adm_academica") && $estadoActual->descriptionIs(Status::ADMINISTRACION_ACADEMICA)
          ) ||
          (
            PermisosHelpers::requerirRol("Sec_academica") && $estadoActual->descriptionIs(Status::SECRETARIA_ACADEMICA)
          );
    }
  
}
