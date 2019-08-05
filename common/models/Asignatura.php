<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "asignatura".
 *
 * @property int $id
 * @property string $nomenclatura
 * @property int $curso
 * @property int $cuatrimestre
 * @property int $carga_horaria_sem
 * @property int $carga_horaria_cuatr
 * @property int $plan_id
 * @property int $departamento_id
 *
 * @property Departamento $departamento
 * @property Plan $plan
 * @property Programa[] $programas
 */
class Asignatura extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'asignatura';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nomenclatura', 'curso', 'cuatrimestre'], 'required', 'message' => 'Complete este campo'],
            [['nomenclatura', 'curso', 'cuatrimestre','plan_id','orden'], 'required', 'on' => 'create', 'message' => 'Complete este campo'],
            [['orden','curso', 'cuatrimestre', 'carga_horaria_sem', 'carga_horaria_cuatr', 'plan_id', 'departamento_id'], 'integer'],
            [['nomenclatura'], 'string', 'max' => 255],
            [['departamento_id'], 'exist', 'skipOnError' => true, 'targetClass' => Departamento::className(), 'targetAttribute' => ['departamento_id' => 'id']],
            [['plan_id'], 'exist', 'skipOnError' => true, 'targetClass' => Plan::className(), 'targetAttribute' => ['plan_id' => 'id']],
        ];
    }
    public function scenarios(){
        $scenarios = parent::scenarios();
        $scenarios['create'] = ['nomenclatura','curso','plan_id','cuatrimestre','orden'];
        return $scenarios;

    }
    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nomenclatura' => 'Nomenclatura',
            'plan_id' => 'Plan ID',
            'orden' => 'Orden',
            'curso' => 'Curso',
            'cuatrimestre' => 'Cuatrimestre',
            'carga_horaria_sem' => 'Carga Horaria Sem',
            'carga_horaria_cuatr' => 'Carga Horaria Cuatr',
            'departamento_id' => 'Departamento',
        ];
    }
    /**
    * @return \yii\db\ActiveQuery
    */
    public function getDepartamento()
    {
       return $this->hasOne(Departamento::className(), ['id' => 'departamento_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPlan()
    {
        return $this->hasOne(Plan::className(), ['id' => 'plan_id']);
    }

    public function getOrden(){
        return $this->orden;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProgramas()
    {
        return $this->hasMany(Programa::className(), ['asignatura_id' => 'id']);
    }
    public function getNomenclatura()
    {
      return $this->nomenclatura;
    }
    public function getCurso()
    {
        switch ($this->curso) {
            case 0:
                return "N/N";
                break;
            case 1:
                return "Primer año";
                break;
            case 2:
                return "Segundo año";
                break;
            case 3:
                return "Tercero año";
                break;
            case 4:
                return "Cuarto año";
                break;
            case 5:
                return "Quinto año";
                break;
            case 6:
                return "Sexto año";
                break;
            default:
                return "N/N" ;
        }
    }
    public function getCuatrimestre(){
        switch ($this->cuatrimestre) {
            case 0:
                return "N/N";
                break;
            case 1:
                return "Primer cuatrimestre";
                break;
            case 2:
                return "Segundo cuatrimestre";
                break;
            default:
                return "N/N" ;
        }
    }
    public function getCargaHorariaSem(){
        return $this->carga_horaria_sem;
    }
    public function getCargaHorariaCuatr(){
        return $this->carga_horaria_cuatr;
    }
    
}
