<?php

namespace api\modules\v1\models;
use yii\web\Link;
use yii\web\Linkable;
use Yii;
use yii\helpers\Url;

/**
 * This is the model class for table "plan".
 *
 * @property int $id
 * @property string $planordenanza
 * @property int $carrera_id
 *
 * @property Asignatura[] $asignaturas
 * @property Carrera $carrera
 */
class Plan extends \yii\db\ActiveRecord implements Linkable
{
    private $version = "v1";
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'plan';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['planordenanza'], 'required'],
            [['carrera_id'], 'integer'],
            [['activo'],'boolean'],
            [['planordenanza'], 'string', 'max' => 255],
            [['archivo'], 'file', 'skipOnEmpty' => false, 'extensions' => 'pdf'],
            [['carrera_id'], 'exist', 'skipOnError' => true, 'targetClass' => Carrera::className(), 'targetAttribute' => ['carrera_id' => 'id']],
        ];
    }

    public function fields(){
        return [
            'id',
            'ordenanza' => 'planordenanza',
            'activo' => function($model){
                return $model->activo ?
                    true : false;
            },
            'archivo' => function($model){
                return ($model->archivo ?\Yii::$app->urlManagerBackend->baseUrl.'/planFiles/'.$model->archivo  : '');
            },
            /*'carrera' => function(){
                return $this->carrera_id ? 
                    Url::base(true)."/".$this->version."/carrera/".$this->carrera_id
                    :
                    null;
            }*/
        ];
    }
    public function getLinks(){
        return [
            Link::REL_SELF => Url::to(['plan/'.$this->id], true),
            //'edit' => Url::to(['user/view', 'id' => $this->id], true),
            'asignaturas' => Url::to(['asignatura/plan','id' => $this->id], true),
            //'index' => Url::to(['dpto'], true),
        ];    
    }
    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'id',
            'planordenanza' => 'ordenanza',
            'carrera_id' => 'carrera_id',
            'archivo' => 'archivo',
        ];
    }
    public function getOrdenanza(){
        return $this->planordenanza;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAsignaturas()
    {
        return $this->hasMany(Asignatura::className(), ['plan_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCarrera()
    {
        return $this->hasOne(Carrera::className(), ['id' => 'carrera_id']);
    }
}
