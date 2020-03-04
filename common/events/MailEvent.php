<?php 
namespace common\events;

use yii\base\Component;
use yii\base\Event;


class MailEvent extends Component 
{
    const EVENT_SEND = 'enviarMensaje';
    const EVENT_HELLO = 'hola';

    public function init(){

        $this->on(self::EVENT_SEND, [$this, 'enviarMensaje']);
      
        // first parameter is the name of the event and second is the handler. 
        // For handlers I use methods sendMail and notification
        // from $this class.
        parent::init(); // DON'T Forget to call the parent method.
      }
    public function ejecutar($event)
    {   
        
        $this->trigger(self::EVENT_HELLO);
        echo $event->data;
    }

    public function enviarMensaje($message){
        \Yii::$app->mailer->compose()
            ->setFrom(getenv("SMTP_USER"))
            ->setTo('miusuario@dominio.com')
            ->setSubject('Email enviado desde Yii2-Swiftmailer')
            ->send();
    }
}
