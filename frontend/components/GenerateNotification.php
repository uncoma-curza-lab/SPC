<?php
namespace frontend\components;

use Yii;
use yii\base\Component;
use yii\base\InvalidConfigException;
use common\models\Programa;
use common\events\NotificationEvent;
class GenerateNotification extends Component
{
 public function run($eventType,$programaID)
 {
    if (! \Yii::$app->user->isGuest ){
        $userInitID = \Yii::$app->user->identity->id;
    }
    $userReceiverID = Programa::findOne($programaID)->created_by;
    $notificar = new NotificationEvent($eventType,$userInitID ,$userReceiverID,$programaID);
    $this->on($eventType,[$notificar,'notificar']); 
    $this->trigger($eventType,$notificar);
 }
 
}