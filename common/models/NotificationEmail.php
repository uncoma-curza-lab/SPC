<?php

namespace common\models;
use common\events\MailEvent;
use Yii;

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
            [['receiver_user'],'required'],
            [['init_user'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['init_user' => 'id']],
            [['receiver_user'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['receiver_user' => 'id']],
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
 
}