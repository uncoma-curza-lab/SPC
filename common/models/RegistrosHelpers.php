<?php
namespace common\models;

use yii;

class RegistrosHelpers
{
    public static function userTiene($modelo_nombre)
    {
        $conexion = \Yii::$app->db;
        $userid = Yii::$app->user->identity->id;
        $sql = "SELECT id FROM $modelo_nombre WHERE user_id=:userid";
        $comando = $conexion->createCommand($sql);
        $comando->bindValue(":userid", $userid);
        $resultado = $comando->queryOne();
        if ($resultado == null) {
            return false;
        } else {
            return $resultado['id'];
        }
    }
    public static function getUserName($id){
      if ($user = User::findIdentity($id)){
        return $user->username;
      }
      else {
        return '';
      }
    }
    /**
    * @deprecated
    */
    public static function getNombreApellidoUser($id){
      if ($user = User::findIdentity($id)){
        if($user->perfil){
          return $user->perfil->nombre." ".$user->perfil->apellido;
        }
      }
      return '';
    }
}
