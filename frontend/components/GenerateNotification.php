<?php
namespace frontend\components;

use Yii;
use yii\base\Component;
use yii\base\InvalidConfigException;
use common\models\Programa;
use common\events\NotificationEvent;
use common\models\Status;
use common\models\User;
use common\models\Designacion;
use common\models\Cargo;
use frontend\models\Perfil;
use common\models\Rol;
class GenerateNotification extends Component
{
    public function creador($eventType,$programaID)
    {
        $emisor = $this->getActualUser();
        $receptor = Programa::findOne($programaID)->created_by;
        $notificar = new NotificationEvent($eventType,$emisor ,$receptor,$programaID);

        $this->run($eventType,$notificar);
        $this->trigger($eventType,$notificar);
        $this->off($eventType,[$notificar,'notificar']);
    }
    public function suscriptores($eventType,$programaID)
    {
        $suscriptores = $this->suscriptoresXEstado($programaID);
        $emisor = $this->getActualUser();
        $notificar = null;
        foreach ($suscriptores as $suscriptor) {
            $notificar = new NotificationEvent($eventType,$emisor ,$suscriptor->id,$programaID);        
            $this->run($eventType,$notificar);
            
        }
        if( $notificar )
            $this->trigger($eventType,$notificar);
        
    }

    protected function run($eventType,$notificar){
        $this->on($eventType,[$notificar,'notificar']); 
    }

    protected function getActualUser(){
        $userInitID = null;
        if (! \Yii::$app->user->isGuest ){
            $userInitID = \Yii::$app->user->identity->id;
        }
        return $userInitID;
    }
    protected function suscriptoresXEstado($programa_id){
        $programa = Programa::findOne($programa_id);
        $status = Status::findOne($programa->status_id);
        $statusDescripcion = $status->getDescripcion();
        $estadoVsRol = [
          'Administración Académica' => 'Adm_academica', 
          'Secretaría Académica' => 'Sec_academica' ,
          'Departamento' => 'Departamento'
        ];

        $suscriptores = [];
        if($statusDescripcion == "Departamento") {
            // si es director tiene una designación con ese cargo
            // es un usuario, que tiene designacion de director
            // del dpto 
            $cargoDirector = Cargo::find()
                ->where(['=','nomenclatura','Director'])->one();
            $designaciones = Designacion::find()
                ->filterWhere(['=','cargo_id',$cargoDirector->id])
                ->andFilterWhere(['=','departamento_id',$programa->departamento_id])
                ->all();
            foreach ($designaciones as $designacion) {
                $perfil = $designacion->perfil_id;
                $user = Perfil::findOne($perfil);
                
                if ( $user ){
                    $user = $user->getUser()->one();
                }
                array_push($suscriptores,$user);
            }
        }else if(!empty($estadoVsRol[$statusDescripcion])) {
            $rolID = Rol::find()
                ->where(['rol_nombre' => $estadoVsRol[$status->getDescripcion()]])
                ->one();
            $rolID = $rolID ? $rolID->id : null;
            $users = User::find()->where(['rol_id' => $rolID])->all();
            $suscriptores = $users;
        }

        return $suscriptores;
  
    }


}