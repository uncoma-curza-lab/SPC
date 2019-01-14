<?php

namespace backend\models;

use Yii;
use common\models\User;

/**
 * This is the model class for table "designacion".
 *
 * @property int $id
 * @property int $cargo_id
 * @property int $user_id
 * @property int $programa_id
 *
 * @property Cargo $cargo
 * @property Programa $programa
 * @property User $user
 */
class Designacion extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'designacion';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['cargo_id', 'user_id', 'programa_id'], 'integer'],
            [['cargo_id'], 'exist', 'skipOnError' => true, 'targetClass' => Cargo::className(), 'targetAttribute' => ['cargo_id' => 'id']],
            [['programa_id'], 'exist', 'skipOnError' => true, 'targetClass' => Programa::className(), 'targetAttribute' => ['programa_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'cargo_id' => 'Cargo ID',
            'user_id' => 'User ID',
            'programa_id' => 'Programa ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCargo()
    {
        return $this->hasOne(Cargo::className(), ['id' => 'cargo_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPrograma()
    {
        return $this->hasOne(Programa::className(), ['id' => 'programa_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
