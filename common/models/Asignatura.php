<?php

namespace common\models;

use Yii;
use yii\web\Linkable;
use yii\web\Link;
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
class Asignatura extends \yii\db\ActiveRecord implements Linkable
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
            [['requisitos'],'string'],
            [['nomenclatura'], 'string', 'max' => 255],
            [['departamento_id'], 'exist', 'skipOnError' => true, 'targetClass' => Departamento::class, 'targetAttribute' => ['departamento_id' => 'id']],
            [['plan_id'], 'exist', 'skipOnError' => true, 'targetClass' => Plan::class, 'targetAttribute' => ['plan_id' => 'id']],
            [['parent_id'], 'exist', 'skipOnError' => true, 'targetClass' => Asignatura::class, 'targetAttribute' => ['parent_id' => 'id']],
        ];
    }

    public function scenarios(){
        $scenarios = parent::scenarios();
        $scenarios['create'] = [
            'nomenclatura',
            'carga_horaria_sem',
            'carga_horaria_cuatr',
            'curso',
            'plan_id',
            'cuatrimestre',
            'orden',
            'departamento_id',
            'parent_id',
        ];
        return $scenarios;

    }

    public function fields(){
        return [
            'id',
            'nombre' => 'nomenclatura',
            'ano_dictado' => 'curso',
            'orden' => 'orden',
            'cuatrimestre' => 'cuatrimestre',
            'carga_sem' => 'carga_horaria_sem',
            'plan' => 'plan_id',
            'carga_total' => 'carga_horaria_cuatr',
            'requisitos' => 'requisitos',
            'correlativas' => function($model){
                $correlativas = $model->getCorrelativas()->select('correlativa_id')->all();
                $array = [];
                foreach($correlativas as $correlativa){
                    if ($correlativa->getCorrelativa()->one()){
                        $asig = Asignatura::findOne($correlativa);
                        
                        array_push($array,[
                            'orden' => $asig->getOrden(),
                            'nomenclatura' => $asig->getNomenclatura(),
                            'id' => $correlativa->correlativa_id
                        ]);
                    }

                }

                return $array;
            }
        ];
    }

    /**
     * @deprecated use into api
     */
    public function getLinks()
    {
        $withExports = false;
        if (isset($_GET['withExport']) && ( $_GET['withExport'] === "1" || $_GET['withExport'] === 1 )) {
            $bibliotecaStatus = Status::find()->where(['=', 'descripcion', 'Biblioteca'])->one();
            if ($bibliotecaStatus) {
                $bibliotecaId = $bibliotecaStatus->id;
            }
            $programas = $this->getProgramas()->andFilterWhere(['=', 'status_id', $bibliotecaId])->all();
            $exports = [];
            $request = \Yii::$app->request;
            
            foreach($programas as $programa) {
                $exports[$programa->year] = Url::to(['biblioteca/download/' .  $programa->id], 'https');
            }
            $withExports = true;
        }

        $responseLinks = [
            Link::REL_SELF => Url::to(['asignatura/' . $this->id], 'https'),
        ];    
        if ($withExports) {
            $responseLinks['exports'] = $exports;
        }
        return $responseLinks;
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
            'requisitos' => 'Requisitos',
            'parent_id' => 'Asignatura que modifica',
        ];
    }

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getDepartamento()
    {
       return $this->hasOne(Departamento::className(), ['id' => 'departamento_id']);
    }

    public function getCorrelativas()
    {
        return $this->hasMany(Correlativa::className(), ['asignatura_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPlan()
    {
        return $this->hasOne(Plan::className(), ['id' => 'plan_id']);
    }

    public function getParent()
    {
        return $this->hasOne(Asignatura::class, ['id' => 'parent_id']);
    }

    public function getChildrens()
    {
        return $this->hasMany(Asignatura::class, ['parent_id' => 'id']);
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

    public function getRequisitos(){
        return $this->requisitos;
    }

    public function hasChildren()
    {
        return $this->getChildrens()->exists();
    }

    public static function determineCurrentPlan($courseId)
    {
        $course = self::findOne($courseId);
        $plan = $course->plan;
        $currentPlanCareer = null;
        if ($plan->carrera) {
            $currentPlanCareer = $plan->carrera->plan_vigente_id;
        }

        $plan = $plan->getLastAmendingPlan($currentPlanCareer);

        return $plan->id;
    }
}
