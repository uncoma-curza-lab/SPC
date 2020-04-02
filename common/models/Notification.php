<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "rol".
 *
 * @property integer $id
 * @property string $rol_nombre
 * @property integer $rol_valor
 */
abstract class Notification extends \yii\db\ActiveRecord
{
    const DISCR = "Generic";
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%notification}}';
    }
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['message', 'notification_type_id','init_user','receiver_user','event_type_id'], 'required'],
            [['notification_type_id','init_user','receiver_user','event_type_id'], 'integer'],
            [['created_at','updated_at','read'], 'date'],
            [['init_user'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['init_user' => 'id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['created_by' => 'id']],
            [['updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['updated_by' => 'id']],
            [['receiver_user'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['receiver_user' => 'id']],
            [['event_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => EventType::className(), 'targetAttribute' => ['event_type_id' => 'id']],
            [['message'], 'string'],
            [['type'],'string']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'created_by' => 'Creado por',
            'updated_by' => 'Actualizado por',
            'receiver_user' => 'Usuario receptor',
            'init_user' => 'Usuario emisor',
            'message' => 'Mensaje',
            'updated_at' => 'Fecha de actualizacion',
            'created_at' => 'Fecha de creacion',
            'type' => 'Tipo de notificacion',
            'event_type_id' => 'Tipo de evento'
        ];
    }
    
    public static function instantiate($row)
    {
        switch ($row['type']) {
            case NotificationPanel::DISCR:
                return new NotificationPanel();
            case NotificationEmail::DISCR:
                return new NotificationEmail();
            default:
                return null;
        }

        return parent::instantiate($row);
    }
    abstract protected function send();
    abstract protected function getDateSend();

      /**
     * @return \yii\db\ActiveQuery
     */
    public function getEventtype()
    {
        return $this->hasOne(EventType::className(), ['id' => 'event_type_id']);
    }


    public function setMessage($message){
        $this->message = $message;
    }


}
