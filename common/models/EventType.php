<?php

namespace common\models;

use Yii;
use yii\behaviors\SluggableBehavior;
use frontend\models\Perfil;

/**
 * This is the model class for table "notification_type".
 *
 * @property integer $id
 * @property string $name
 * @property string $description
 */
class EventType extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'event_type';
    }
    public function behaviors()
    {
        return [
            [
                'class' => SluggableBehavior::className(),
                'attribute' => 'name',
                // 'slugAttribute' => 'slug',
            ],
        ];
    }
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['message_template','name','slug'], 'required'],
            [['name','slug'],'string','max' => 100],
            [['descripcion'], 'string', 'max' => 200],
            [['message_template'] , 'string']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'message_template' => 'Plantilla de mensaje',
            'description' => 'Descripcion',
            'name' => "Nombre",
            'slug' => "Slug",
        ];
    }

    public function getMessageTemplate(){
        return $this->message_template;
    }
    public function getMessage(User $userInit,User $userReceiver,$programaID){
        $perfilUI = Perfil::find()->where(['=','user_id',$userInit->id])->one();
        $programa = Programa::findOne($programaID);
        $message = "";
        if ($perfilUI && $programaID)
        {
            $message .= str_replace("%user_init%",$perfilUI->printNombre(),$this->message_template);
            $message = str_replace("%programa%",'<i>'.$programa->getNomenclatura().'</i>',$message);
        } else {
            $message = "Hubo un problema con esta notificación.";
        }
        return $message;
    }

    public function getID(){
        return $this->id;
    }

    
}
