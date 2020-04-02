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
class UserSettingsEventType extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user_settings_event_type';
    }

    /**
     * @inheritdoc
     */  'id' =>  $this->primaryKey(),
     'user_id'  => $this->integer(),
     'created_at' => $this->dateTime(),
     'updated_at'  => $this->dateTime(),
     'created_by'  => $this->integer(),
     'updated_by'  => $this->integer(),
    public function rules()
    {
        return [
            [['user_id','event_type_id'], 'required'],
            [['event_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => EventType::className(), 'targetAttribute' => ['event_type_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
            [['active'], 'boolean'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Nombre',
            'description' => 'Descripcion',
        ];
    }
    
}
