<?php

namespace common\models;

use Yii;
use yii\web\Link;
use yii\web\Linkable;
use yii\helpers\Url;

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
            [['nom', 'slug'], 'required' , 'on' => ['create']],
            [['director'], 'integer'],
            [['nom', 'slug'], 'string', 'max' => 255],
        ];
    }

    public function fields()
    {
        return [
            'id',
            'nombre' => 'nom',
            
        ];
    }

    public function extraFields()
    {
        return ['carreras' => function(){ return $this->getCarreras()->all();}];
    }

    public function getLinks()
    {
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
            'director' => 'Director',
            'slug' => 'Slug',
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
    public function getDesignaciones()
    {
        return $this->hasMany(Designacion::className(), ['departamento_id' => 'id']);
    }

    public function getDirector(){
        return $this->hasOne(Designacion::className(),['id' => 'departamento_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProgramas()
    {
        return $this->hasMany(Programa::className(), ['departamento_id' => 'id']);
    }
    
    public function getNomenclatura(){
        return $this->nom;
    }

    public function getNombre()
    {
        return $this->getNomenclatura();
    }
}
