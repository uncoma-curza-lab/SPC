<?php
namespace common\models;
use common\models\ValorHelpers;
use yii;
use yii\web\Controller;
use yii\helpers\Url;
use backend\models\Cargo;
use backend\models\Programa;
class PermisosHelpers
{
    public static function requerirProfesorAdjunto($programaID){
      $programa = Programa::find()->where(['=','id',$programaID])->one();
      if (isset($programa)){
          $cargoProfAdj = Cargo::find()->where(['=','carga_programa',1])->one();
          $designaciones = $programa->getDesignaciones();
          $profesor = $designaciones->where(['=','cargo_id',$cargoProfAdj->id])->one();
          $userId = \Yii::$app->user->identity->id;
          if ($userId == $profesor->user_id) {
            return true;
          } else {
            return false;
          }
      }
      return false;
    }

    public static function requerirDirector($programaID){
      $programa = Programa::findOne($programaID);
      $userId = \Yii::$app->user->identity->id;

      if ($programa->getDepartamento()->one()->director == $userId){
        return true;
      } else {
        return false;
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
}
