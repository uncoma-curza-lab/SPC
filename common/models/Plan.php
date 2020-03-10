<?php

namespace common\models;

use Yii;

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
class Plan extends \yii\db\ActiveRecord
{
    public $planArchivo;

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
            [['archivo'],'string'],
            //puede ser vacio el archivo skipOnEmpty
            [['planArchivo'], 'file', 'skipOnEmpty' => true, 'extensions' => 'pdf'],
            // puede no tener carrera_id  o fallar la validación
            [['carrera_id'], 'exist', 'skipOnError' => true, 'targetClass' => Carrera::className(), 'targetAttribute' => ['carrera_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'planordenanza' => 'Planordenanza',
            'carrera_id' => 'Carrera ID',
            'activo' => 'activo',
            'archivo' => 'Path Archivo'
        ];
    }

    public function upload()
    {
        if ($this->validate()) {
            //$this->archivo->saveAs('planFiles/' . $this->archivo->baseName."-" .date('y-m-d_his') . '.' . $this->archivo->extension);
            $carreraName = $this->getCarrera();
            $carreraName = $carreraName ? $carreraName->one() : null;
            $carreraName = $carreraName ? $carreraName->nom : null;
            if($carreraName){
                $carreraName = $this->parseName($carreraName);
                $filename=$carreraName .'_'.str_replace("/","-",$this->getOrdenanza()).'_'.date('dmyhis').".". $this->planArchivo->extension;
                $this->archivo = $filename;

                $this->planArchivo->saveAs('planFiles/'.$filename,false);
                
                return true;
            } else
                return false;
        } else {
            return false;
        }
    }
    private function parseName($string) {
        $string = htmlentities($string);
        $string = str_replace(" ", "",$string);
        $string = strtolower($string);
        $string = preg_replace('/\&(.)[^;]*;/', '\\1', $string);
        return $string;
    }
    
    public function getActivo(){
        return $this->activo;
    }
    public function setActivo($bool){
        $this->activo = $bool;
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

    public function getOrdenanza(){
      return $this->planordenanza;
    }
    public function getArchivo(){
        return $this->archivo;
    }
    public function setArchivo($filePath){
        $this->archivo = $filePath;
    }
}
