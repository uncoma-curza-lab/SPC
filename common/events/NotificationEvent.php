<?php 
namespace common\events;

use yii\base\Component;
use yii\base\Event;

use common\models\EventType;
use common\models\User;
use common\models\NotificationPanel;
use common\models\NotificationEmail;

class NotificationEvent extends Event 
{
    protected $eventType;
    protected $userInit;
    protected $userReceiver;
    protected $message;
    protected $programaID;
    protected $notificationPanel,$notificationEmail;

    public function __construct($eventType, $uInit,  $uReceiver, $programaId){
        $this->eventType = $this->getEventType($eventType);
        $this->userInit = $uInit;
        $this->userReceiver = $uReceiver;
        $this->programaID = $programaId;
        $message = "";
        parent::__construct();
    }
    //notificarObsrvacions
    public function notificar()
    {
        $this->configMessage();
        $this->notificationPanel();
        $this->notificationEmail();
        //$notificationEmail = new NotificationEmail();
    }

    public function setUserInit(User $uInit){
        $this->userInit = $uInit;
    }

    public function setUserReceiver(User $uReceiver){
        $this->userReceiver = $uReceiver;
    }

    public function setEventType(EventType $eventType){
        $this->eventType = $eventType;
    }

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
    protected function configMessage(){
        $uInit = User::findOne($this->userInit);
        $uReceiver = User::findOne($this->userReceiver);
        $this->message = $this->eventType
            ->getMessage($uInit,$uReceiver,$this->programaID);
    }
    protected function getEventType($eventType){
        return EventType::find()->where(['=','slug',$eventType])->one();
    }
    protected function notificationPanel(){
        $notificationPanel = new NotificationPanel();
        $notificationPanel->setMessage($this->message); 
        $notificationPanel->setUserReceiverID($this->userReceiver);
        $notificationPanel->setUserInitID($this->userInit);
        $notificationPanel->setEventTypeID($this->eventType->getID());
        $notificationPanel->setProgramaID($this->programaID);
        $notificationPanel->save();
    }
    protected function notificationEmail()
    {
        $notificationEmail = new NotificationEmail();
        $notificationEmail->setMessage($this->message); 
        $notificationEmail->setUserReceiverID($this->userReceiver);
        $notificationEmail->setUserInitID($this->userInit);
        $notificationEmail->setEventTypeID($this->eventType->getID());
        $notificationEmail->setProgramaID($this->programaID);
        $userReceiver = User::findOne($this->userReceiver);
        if ( $userReceiver ) {
            $userEmail = $userReceiver->getEmail();
            
            $sendMail = \Yii::$app->mailer->compose()
            ->setFrom(getenv("SMTP_USER"))
            ->setTo($userEmail)
            ->setSubject($this->eventType->descripcion)
            ->setTextBody($this->message)
            ->send();
            $notificationEmail->save();
        }
        
    }
}

