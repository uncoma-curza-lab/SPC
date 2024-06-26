<?php

namespace common\models;

use common\models\querys\PlanQuery;
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
class Plan extends BaseModel 
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
            [['carrera_id'], 'exist', 'skipOnError' => true, 'targetClass' => Carrera::class, 'targetAttribute' => ['carrera_id' => 'id']],
            [['parent_id'], 'exist', 'skipOnError' => true, 'targetClass' => Plan::class, 'targetAttribute' => ['parent_id' => 'id']],
            [['root_plan_id'], 'exist', 'skipOnError' => true, 'targetClass' => Plan::class, 'targetAttribute' => ['root_plan_id' => 'id']],
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
            'archivo' => 'Path Archivo',
            'parent_id' => 'Plan o modificatoria superior',
            'root_plan_id' => 'Plan origen',
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
        return $this->hasMany(Asignatura::class, ['plan_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCarrera()
    {
        return $this->hasOne(Carrera::class, ['id' => 'carrera_id']);
    }

    public function getParent()
    {
        return $this->hasOne(Plan::class, ['id' => 'parent_id']);
    }

    public function getRoot()
    {
        return $this->hasOne(Plan::class, ['id' => 'root_plan_id']);
    }

    public function getChild()
    {
        return $this->hasOne(Plan::class, ['parent_id' => 'id']);
    }

    public function hasChild()
    {
        return $this->getChild()->exists();
    }

    public function getOrdenanza()
    {
        return $this->planordenanza;
    }

    public function getArchivo()
    {
        return $this->archivo;
    }

    public function setArchivo($filePath){
        $this->archivo = $filePath;
    }

    public function getLastAmendingPlan(int $limitPlanId = null)
    {
        if (!$this->child || $this->id == $limitPlanId) {
            return $this;
        }

        return $this->child->getLastAmendingPlan($limitPlanId);
    }

    public static function getRootPlan($planId)
    {
        $plan = Plan::findOne($planId);
        $parentId = $plan->parent_id;

        if (!$parentId) {
            return $plan;
        }

        return Plan::getRootPlan($parentId);
    }

    public function getCoursesTreeFromRoot(int $targetPlanId = null)
    {
        $root = $this->root_plan_id ? $this->root : $this;
        if ($targetPlanId == $root->id) {
            return $root->asignaturas;
        }

        $courses = [];
        foreach ($root->asignaturas as $course) {
            $courses[$course->id] = $course;
        }


        $child = $root->child;
        while($child) {

            foreach($child->asignaturas as $courseChild) {
                if (in_array($courseChild->parent_id, array_keys($courses))) {
                    unset($courses[$courseChild->parent_id]);
                }
                $courses[$courseChild->id] = $courseChild;
            }

            if ($targetPlanId == $child->id) {
                break;
            }

            $child = $child->child;
        }

        return array_values(array_filter($courses));

    }

    public static function find()
    {
        $class = get_class(Yii::$container->get(static::class));
        return new PlanQuery($class);
    }
}
