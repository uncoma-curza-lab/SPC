<?php 
namespace common\events;

use yii\base\Component;
use yii\base\Event;


class NotificationEvent extends Event 
{
    public $message;
    public function setMessage($message){
        $this->message = $message;
    }
    public function enviarMensaje(){
        \Yii::$app->mailer->compose()
            ->setFrom(getenv("SMTP_USER"))
            ->setTo('njmdistrisoft@gmail.com')
            ->setSubject($this->message)
            ->send();
    }
}
