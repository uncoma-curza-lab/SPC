<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "notification_type".
 *
 * @property integer $id
 * @property string $name
 * @property string $description
 */
class NotificationPanel extends Notification
{
    const DISCR = 'NotificationPanel';

    public static function tableName () {
        return '{{%notification}}';
    }
    
    public function init()
    {
        parent::init();
        $this->type = self::DISCR;
        
      
        //mensaje leido? no...
        //$this->read = null;
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            //[['name'], 'required'],
            [['message'] ,'string'],
            [['receiver_user'],'required'],
            [['init_user'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['init_user' => 'id']],
            [['receiver_user'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['receiver_user' => 'id']],
            [['read'], 'date'],
        ];
    }

    public function send(){
        //enviar al panel del usuario.
    }
 
    public function getDateSend(){
        //enviar al panel del usuario.
    }

    public function getNotificationType(){
        return $this->hasOne(NotificationType::className(), ['id' =>  self::DISCR]);
    }
       
}
