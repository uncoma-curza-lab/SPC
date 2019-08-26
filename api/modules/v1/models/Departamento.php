<?php

namespace api\modules\v1\models;
use yii\web\Link;
use yii\web\Linkable;
use yii\helpers\Url;
use Yii;
use common\models\User;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "departamento".
 *
 * @property int $id
 * @property string $nom
 * @property string $slug
 * @property int $director
 * @property Asignatura[] $asignaturas
 * @property Carrera[] $carreras
 * @property User $director0
 * @property Programa[] $programas
 */
class Departamento extends \yii\db\ActiveRecord implements Linkable
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'departamento';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nom', 'slug'], 'required'],
            [['director'], 'integer'],
            [['nom', 'slug'], 'string', 'max' => 255],
            [['director'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['director' => 'id']],
        ];
    }
    public function fields(){
        return [
            'id',
            'nombre' => 'nom',
            
        ];
    }
    public function extraFields() {

        return ['carreras' => function(){ return $this->getCarreras()->all();}];

    }
    public function getLinks(){
        return [
            Link::REL_SELF => Url::to(['departamento/'.$this->id], true),
            //'edit' => Url::to(['user/view', 'id' => $this->id], true),
            'carreras' => Url::to(['carrera/departamento','id' => $this->id], true),
            //'index' => Url::to(['dpto'], true),
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
            'slug' => 'Slug',
            'director' => 'Director',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCarreras()
    {
        return $this->hasMany(Carrera::className(), ['departamento_id' => 'id']);
    }
    /**
    * @return \yii\db\ActiveQuery
    */
    public function getAsignaturas()
    {
       return $this->hasMany(Asignatura::className(), ['departamento_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDirector()
    {
        return $this->hasOne(User::className(), ['id' => 'director']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProgramas()
    {
        return $this->hasMany(Programa::className(), ['departamento_id' => 'id']);
    }
    public function getNombre(){
        return $this->nom;
    }
}
