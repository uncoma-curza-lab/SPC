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
    public function getUserName($id){
      if ($user = User::findIdentity($id)){
        return $user->username;
      }
      else {
        return '';
      }
    }
}
