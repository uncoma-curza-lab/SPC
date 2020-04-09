<?php

namespace common\models;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\Expression ;
use common\models\querys\NotificationQuery;
use Yii;

/**
 * This is the model class for table "rol".
 *
 * @property integer $id
 * @property string $rol_nombre
 * @property integer $rol_valor
 */
abstract class Notification extends ActiveRecord
{
    const DISCR = "Generic";
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%notification}}';
    }

    public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => 'yii\behaviors\TimestampBehavior',
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
                ],
                'value' => new Expression('NOW()'),
            ],           
        ];
     }

     public $print = '';

     public function afterFind()
     {
         parent::afterFind();
         $this->print = $this->printr();
 
         return $this;
     }
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['message', 'notification_type_id','user_init','user_receiver','event_type_id'], 'required'],
            [['notification_type_id','user_init','user_receiver','event_type_id','programa_id'], 'integer'],
            [['created_at','updated_at','read'], 'date'],
            [['user_init'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_init' => 'id']],
            [['programa_id'], 'exist', 'skipOnError' => true, 'targetClass' => Programa::className(), 'targetAttribute' => ['programa_id' => 'id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['created_by' => 'id']],
            [['updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['updated_by' => 'id']],
            [['user_receiver'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_receiver' => 'id']],
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
            'user_receiver' => 'Usuario receptor',
            'user_init' => 'Usuario emisor',
            'message' => 'Mensaje',
            'updated_at' => 'Fecha de actualizacion',
            'created_at' => 'Fecha de creacion',
            'type' => 'Tipo de notificacion',
            'event_type_id' => 'Tipo de evento'
        ];
    }
    public function printr(){ return ''; }
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

    /**
     * Set message
     * @param string $message
     */
    public function setMessage($message){
        $this->message = $message;
    }

    public function getMessage(){
       /* if ($eventType = $this->getEventtype()->one()) {
            $userInit = User::findOne($this->user_init);
            $userReceiver = User::findOne($this->user_receiver);
            return $eventType->getMessage($userInit,$userReceiver,$this->programa_id);
        } else {
            return "Hubo un problema con esta notificación";
        }*/
        return $this->message;
    }

    public function getCreatedAt()
    {
        if( $this->created_at ){
            $fecha = \Yii::$app->formatter->asDate($this->created_at);
            return $fecha;
        } else {
            return "";
        }
    }

    /**
     * Set id EventType
     * @param integer $id
     */
    public function setEventTypeID($id){
        $this->event_type_id = $id;
    }
    /**
     * Set id User Init
     * @param integer $id
     */
    public function setUserInitID($id){
        $this->user_init = $id;
    }
    /**
     * Set id User Receiver
     * @param integer $id
     */
    public function setUserReceiverID($id){
        $this->user_receiver = $id;
    }

    public function setProgramaID($id){
        $this->programa_id = $id;
    }
    public static function find()
    {
        return new NotificationQuery(get_called_class(), ['type' => self::DISCR]);
    }

}
