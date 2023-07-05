<?php

namespace common\models;

use Yii;

class Departamento extends BaseExtendedModel 
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

    public function extraFields()
    {
        return ['carreras' => function(){ return $this->getCarreras()->all();}];
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
