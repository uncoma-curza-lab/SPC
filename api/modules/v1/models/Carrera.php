<?php

namespace api\modules\v1\models;

use Yii;
use yii\helpers\Url;
/**
 * This is the model class for table "carrera".
 *
 * @property int $id
 * @property string $nom
 * @property int $codigo
 * @property int $departamento_id
 *
 * @property Departamento $departamento
 */
class Carrera extends \yii\db\ActiveRecord
{
    private $version = "v1";
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'carrera';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nom'], 'required'],
            [['departamento_id'], 'integer'],
            [['nom'], 'string', 'max' => 255],
            [['departamento_id'], 'exist', 'skipOnError' => true, 'targetClass' => Departamento::className(), 'targetAttribute' => ['departamento_id' => 'id']],
        ];
    }

    public function fields(){
        return [
            'id',
            'nombre' => 'nom',
            'departamento' => function(){
                return $this->departamento_id ? 
                    Url::base(true)."/".$this->version."/dpto/".$this->departamento_id
                    :
                    null;
            }
        ];
    }
    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nom' => 'Nom',
            'departamento_id' => 'Departamento ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPlanes()
    {
        return $this->hasMany(Plan::className(), ['carrera_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDepartamento()
    {
        return $this->hasOne(Departamento::className(), ['id' => 'departamento_id']);
    }
}
