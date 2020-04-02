<?php
namespace common\events;

use yii\base\Component;
use yii\base\Event;

class EventManager extends Component 
{
    public $events = [];
    const EVENT_SEND = 'enviarMensaje';
    const EVENT_HELLO = 'hola';
     /**
     * @inheritdoc
     */
    public function init()
    {
        $this->on(self::EVENT_SEND, [new MailEvent, 'enviarMensaje']);
        parent::init();
      
        // first parameter is the name of the event and second is the handler. 
        // For handlers I use methods sendMail and notification
        // from $this class.
    }
    /*public function ejecutar($event)
    {   
        
        $this->trigger(self::EVENT_HELLO);
        echo $event->data;
    }*/
    public function sendMail($message){
        $event = new MailEvent();
        $event->setMessage($message);
        $this->trigger(self::EVENT_SEND,$event);
    }
}