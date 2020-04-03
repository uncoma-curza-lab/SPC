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
            [['user_receiver'],'required'],
            [['user_init'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_init' => 'id']],
            [['user_receiver'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_receiver' => 'id']],
            [['programa_id'], 'exist', 'skipOnError' => true, 'targetClass' => Programa::className(), 'targetAttribute' => ['programa_id' => 'id']],
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
