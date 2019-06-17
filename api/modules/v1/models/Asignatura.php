<?php

namespace api\modules\v1\models;

use Yii;
use api\modules\v1\models\Departamento;
use yii\helpers\Url;

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
    private $version = "v1";
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
            [['nomenclatura', 'curso', 'cuatrimestre'], 'required'],
            [['curso', 'cuatrimestre', 'carga_horaria_sem', 'carga_horaria_cuatr', 'plan_id', 'departamento_id'], 'integer'],
            [['nomenclatura'], 'string', 'max' => 255],
            [['departamento_id'], 'exist', 'skipOnError' => true, 'targetClass' => Departamento::className(), 'targetAttribute' => ['departamento_id' => 'id']],
            [['plan_id'], 'exist', 'skipOnError' => true, 'targetClass' => Plan::className(), 'targetAttribute' => ['plan_id' => 'id']],
        ];
    }

    public function fields(){
        return [
            'id',
            'nombre' => 'nomenclatura',
            'año_dictado' => 'curso',
            'cuatrimestre' => 'cuatrimestre',
            'carga_sem' => 'carga_horaria_sem',
            'carga_total' => 'carga_horaria_cuatr',
            'plan' => function(){
                return $this->plan_id ? 
                    Url::base(true)."/".$this->version."/plan/".$this->plan_id
                    :
                    null;
            }
            
        ];
    }
/*    public function fields(){
        $fields = parent::fields();
        unset($fields['departamento_id']);
        return $fields;
    }*/
    
    //public function extraFields() {
    //    return ['nomenclatura'];
    //}
    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nomenclatura' => 'Nomenclatura',
            'plan_id' => 'Plan ID',
            'curso' => 'Curso',
		        'cuatrimestre' => 'Cuatrimestre',
		        'carga_horaria_sem' => 'Carga Horaria Sem',
		        'carga_horaria_cuatr' => 'Carga Horaria Cuatr',
            'departamento_id' => 'Departamento ID',
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
      return $this->curso;
    }
}
