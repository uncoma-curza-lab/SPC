<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "cargo".
 *
 * @property int $id
 * @property int $notification_name
 * @property int $active
 *
 */
class ControlNotification extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'control_notification';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['active'], 'boolean'],
             [['notification_name'], 'string', 'max' => 255],
             [['notification_name'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'active' => 'Activo',
            'notification_name' => 'Nombre de Notificacion', 
        ];
    }

    public function setNotificationName(String $not){
        $this->notification_name = $not;
    }

    public function getNotificationName(){
        return $this->notification_name;
    }

    public function alterateStatus(){
        $this->active = !$this->active;
    }

    public function getStatus(){
        return $this->active;
    }

    public function setStatus(Boolean $bool){
        $this->active = $bool;
    }

    public static function getStatusNotification(String $name){
        
        $notifControl = ControlNotification::find()->where(['notification_name' => $name])->one();
        if ($notifControl){
            return $notifControl->getStatus();
        }

    }
}
