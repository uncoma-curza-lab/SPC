<?php

namespace common\models;

use Yii;
use frontend\models\Perfil;

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
class Departamento extends \yii\db\ActiveRecord
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
}
