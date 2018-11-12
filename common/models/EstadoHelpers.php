<?php
namespace common\models;
use yii;
use yii\web\Controller;
use yii\helpers\Url;
use backend\models\Status;

class EstadoHelpers
{
    public static function getValue($nombre)
    {
      $status = Status::find('value')->where(['descripcion' => $nombre])->one();
      return isset($status) ? $status->value : false;
      //$userid = Yii::$app->user->identity->perfil;
      /*if(PermisosHelpers::requerirRol('Profesor')) {
        // $perfil = \Yii::$app->user->identity->perfil;
        $status = Status::find()->where(['like','descripcion','Departamento'])->one()->value;
      }
      if(PermisosHelpers::requerirRol('Departamento')) {
        //obtiene el peso de sec academica
        $status = Status::find()->where(['like','descripcion','Secretaria academica'])->one()->value;
        //filtra todos los menores al peso
      }

      if ( $status == null )
        $status = 0;
      return $status;*/
    }

    public static function userDebeSerPropietario($model_nombre, $model_id)
    {
        $connection = \Yii::$app->db;
        $userid = Yii::$app->user->identity->id;
        $sql = "SELECT id FROM $model_nombre WHERE user_id=:userid AND id=:model_id";
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
