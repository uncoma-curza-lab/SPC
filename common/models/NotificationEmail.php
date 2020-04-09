<?php

namespace common\models;
use common\events\MailEvent;
use Yii;
use common\models\querys\NotificationQuery;


/**
 * This is the model class for table "notification_type".
 *
 * @property integer $id
 * @property string $name
 * @property string $description
 */
class NotificationEmail extends Notification
{
    const DISCR = 'NotificationEmail';

    public static function tableName () {
        return '{{%notification}}';
    }
    
    public function rules()
    {
        return [
            //[['name'], 'required'],
            [['message'] ,'string'],
            [['user_receiver'],'required'],
            [['user_init'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_init' => 'id']],
            [['user_receiver'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_receiver' => 'id']],
            [['programa_id'], 'exist', 'skipOnError' => true, 'targetClass' => Programa::className(), 'targetAttribute' => ['programa_id' => 'id']],
        ];
    }

    public function init()
    {
        parent::init();
        $this->type = self::DISCR;
      
        //mensaje leido? no...
        $this->read = null;
    }

 

    public function send(){
        //enviar al mail del usuario.
        //$this->layout = "portal";
        
        //$event->ejecutar();
       // $event->on(MailEvent::EVENT_SEND,'sendMessage','hola');
        $event = new MailEvent();
        $event->setMessage("hihii");
        $event->enviarMensaje();
        
        //enviar un mail
        /*
        $event = new MailEvent();
        $event->trigger(MailEvent::EVENT_SEND);*/
    }
    public function getDateSend(){}
    
    public function setMessage($message){
        $this->message = $message;
    }
    public function getMessage()
    {
        $message ="";
        $message = "<p>Hola,</p>".
            "<p>Ha recibido una notificación desde el sistema de programas de cátedra del C.U.R.Z.A.</p>".
            "<p>Este mensaje ha sido autogenerado por el sistema, por favor, no responda. </p>";
            "<p>A continuación se muestra el detalle: </p>";
        $message .= $this->message;
        $message .= "<p></p>";
        $message .="<small>Si por alguna razón cree que no 
            debería haber recibido este mensaje, ignórelo o comuníquese 
            con el departamento de Informática del C.U.R.Z.A.</small>".
            "<small>Podrá encontrar nuestro contacto en 
            <a href='https://apps.curza.uncoma.edu.ar'> este enlace</a></small>".
            "<small>Este mensaje ha sido autogenerado por el sistema, por favor, no responda. </small>";
        return $message;
    }
    public static function find()
    {
        return new NotificationQuery(get_called_class(), ['type' => self::DISCR]);
    }
}