<?php

namespace common\models;

use Yii;
use frontend\models\Perfil;
use yii\db\Expression;
use yii\behaviors\BlameableBehavior;
use yii\db\ActiveRecord;
use yii\helpers\Url;
use yii\web\Link;
use yii\web\Linkable;

class Programa extends BaseModel
{
    const EVENT_NEW_PROGM = 'nuevo-programa';

    const MIN_LOAD_PERCENTAGE = 60;

    const CREATE_PROGRAM_STEP = 'create';
    const FUNDAMENTALS_STEP = 'fundamentals';
    const PLAN_OBJECTIVE_STEP = 'plan-objective';
    const PROGRAM_OBJECTIVE_STEP = 'program-objective';
    const PLAN_CONTENT_STEP = 'plan-content';
    const ANALYTICAL_CONTENT_STEP = 'analytical-content';
    const BIBLIOGRAPHY_STEP = 'bibliography';
    const METHOD_PROPOSAL_STEP = 'method-proposal';
    const EVALUATION_AND_ACCREDITATION_STEP = 'evaluation-accreditation';
    const EXAMS_AND_PROMOTION_STEP = 'exams-promotion';
    const TIME_DISTRIBUTION_STEP = 'time-distribution';
    const TIMELINE_STEP = 'timeline';
    const ACTIVITIES_STEP = 'activities';
    const SIGN_STEP = 'sign';
    const SAVE_STEP = 14;

    const STEPS = [
        'create',
        'fundamentals',
        'plan-objective',
        'program-objective',
        'plan-content',
        'analytical-content',
        'bibliography',
        'method-proposal',
        'evaluation-accreditation',
        'exams-promotion',
        'time-distribution',
        'timeline',
        'activities',
        'sign',
        'save'
    ];

    public static function find()
    {
        return parent::find()->where(['is', 'deleted_at', null]);
        //return Yii::createObject(ActiveQuery::className(), [get_called_class()]);
    }

    public function sendMain($event){
      echo 'mail sent';
    }

    public function notificacion($event){
      echo "evento";
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'programa';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['departamento_id', 'status_id', 'asignatura_id', 'year', 'created_by', 'updated_by', 'current_plan_id'], 'integer'],
            [['asignatura_id','year'], 'required', 'on' => 'crear', 'message'=>"Debe completar este campo"],
            [['asignatura_id','year'], 'required', 'on' => 'copy', 'message'=>"Debe completar este campo"],
            //[['fundament'], 'required', 'on' => 'fundamentacion', 'message'=>"Debe completar este campo"],
            [['biblio_basica','firma','objetivo_programa','contenido_analitico','fundament', 'objetivo_plan', 'contenido_plan', 'propuesta_met', 'evycond_acreditacion', 'parcial_rec_promo', 'distr_horaria', 'crono_tentativo', 'actv_extracur'], 'required','message'=>"Debe completar este campo"],
            [['equipo_catedra'],'required','on' => 'equipo_catedra','message' => "Debe completar este campo"],
            [['firma','biblio_basica','biblio_consulta','equipo_catedra','contenido_analitico','fundament', 'objetivo_plan', 'contenido_plan', 'propuesta_met', 'evycond_acreditacion', 'parcial_rec_promo', 'distr_horaria', 'crono_tentativo', 'actv_extracur'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['asignatura_id'], 'exist', 'skipOnError' => true, 'targetClass' => Asignatura::class, 'targetAttribute' => ['asignatura_id' => 'id']],
            [['departamento_id'], 'exist', 'skipOnError' => true, 'targetClass' => Departamento::class, 'targetAttribute' => ['departamento_id' => 'id']],
            [['status_id'], 'exist', 'skipOnError' => true, 'targetClass' => Status::class, 'targetAttribute' => ['status_id' => 'id']],
            [['current_plan_id'], 'exist', 'skipOnError' => true, 'targetClass' => Plan::class, 'targetAttribute' => ['current_plan_id' => 'id']],
        ];
    }


    public function behaviors()
    {
      return [
        'timestamp' => [
            'class' => 'yii\behaviors\TimestampBehavior',
            'attributes' => [
                ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
            ],
            'value' => new Expression('NOW()'),
        ],
        'blameable' => [
            'class' => BlameableBehavior::class,
            'createdByAttribute' => 'created_by',
            'updatedByAttribute' => 'updated_by',
        ],
      ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'departamento_id' => 'Departamento',
            'status_id' => 'Estado',
            'asignatura_id' => 'Asignatura',
            'curso' => 'Curso',
            'year' => 'Año',
            'cuatrimestre' => 'Cuatrimestre',
            'fundament' => 'Fundament',
            'objetivo_plan' => 'Objetivo Plan',
            'objetivo_programa' => 'Objetivo del Programa',
            'contenido_plan' => 'Contenido Plan',
            'contenido_analitico' => 'Contenido Analítico',
            'biblio_basica' => 'Bibliografía básica',
            'biblio_consulta' => 'Bibliografía de consulta',
            'equipo_catedra' => 'Equipo de catedra',
            'propuesta_met' => 'Propuesta Met',
            'evycond_acreditacion' => 'Evycond Acreditacion',
            'parcial_rec_promo' => 'Parcial Rec Promo',
            'distr_horaria' => 'Distr Horaria',
            'crono_tentativo' => 'Crono Tentativo',
            'actv_extracur' => 'Actv Extracur',
            'firma' => 'Firma',
            'current_plan_id' => 'Plan',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'deleted_at' => 'Eliminado',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
        ];
    }

    public function load($data, $formName = null)
    {
        if (
            ($this->scenario == 'crear' || $this->scenario == 'copy') &&
            $data &&
            array_key_exists('Programa', $data)
        ) {
            $currentPlanId = Asignatura::determineCurrentPlan($data['Programa']['asignatura_id']);
            $data['Programa']['current_plan_id'] = $currentPlanId;
            $this->current_plan_id = $currentPlanId;
        }
        return parent::load($data, $formName);
    }

    public function scenarios(){
      $scenarios = parent::scenarios();
      $scenarios['carrerap'] = ['status_id'];
      $scenarios['crear'] = [
      //  'curso',
        'asignatura_id',
        'current_plan_id',
      //  'cuatrimestre',
        'equipo_catedra',
        'year',
      ];
      $scenarios['copy'] = [
          'asignatura_id',
          'year',
        ];
      $scenarios['equipo_catedra'] = ['equipo_catedra'];
      $scenarios['contenido_analitico'] = ['contenido_analitico'];
      $scenarios['enviarProfesor'] = ['status_id'];
      $scenarios['update'] = [
        'curso',
        'status_id',
        'cuatrimestre',
        'year',
        'asignatura'
      ];

      $scenarios['fundamentacion'] = ['fundament'];
      $scenarios['obj-plan'] = ['objetivo_plan'];
      $scenarios['cont-plan'] = ['contenido_plan'];
      $scenarios['cont-analitico'] = [];
      $scenarios['prop-met'] = ['propuesta_met'];
      $scenarios['eval-acred'] = ['evycond_acreditacion'];
      $scenarios['parc-rec-promo'] = ['parcial_rec_promo'];
      $scenarios['dist-horaria'] = ['distr_horaria'];
      $scenarios['crono-tent'] = ['crono_tentativo'];
      $scenarios['actv-extra'] = ['actv_extracur'];
      $scenarios['pedir'] = ['departamento_id'];
      $scenarios['objetivo-programa'] = ['objetivo_programa'];
      $scenarios['bibliografia'] = ['biblio_basica','biblio_consulta'];
      $scenarios['firma'] = ['firma'];
      return array_merge(parent::scenarios(), $scenarios);
      //return $scenarios;
    }

    public function getPlan()
    {
        if ($this->current_plan_id) {
            return $this->hasOne(Plan::class, ['id' => 'current_plan_id']);
        }

        return $this->hasOne(Plan::class, ['id'=> 'plan_id'])
                    ->viaTable('asignatura', ['id' => 'asignatura_id']);
    }

    /**
     * Obtiene las carreras relacionadas con un programa
     * @return \yii\db\ActiveQuery
     */
    public function getCarreraprogramas()
    {
        return $this->hasMany(Carreraprograma::class, ['programa_id' => 'id']);
    }

    /**
     * Obtiene las designaciones de un programa
     * @deprecated version 1
     * @return \yii\db\ActiveQuery
     */
    public function getDesignaciones()
    {
        return $this->hasMany(Designacion::class, ['programa_id' => 'id']);
    }

    /**
     * Objetivos de un programa
     * @deprecated version 1
     * @return \yii\db\ActiveQuery
     */
    public function getObjetivos()
    {
        return $this->hasMany(Objetivo::class, ['programa_id' => 'id']);
    }

    public function getModules()
    {
        return $this->hasMany(Module::class, ['program_id' => 'id']);
    }

    /**
     * Obtener observaciones de un programa
     * @return \yii\db\ActiveQuery
     */
    public function getObservaciones()
    {
        return $this->hasMany(Observacion::class, ['programa_id' => 'id']);
    }
     /**
     * Obtener observaciones de un programa
     * @return \yii\db\ActiveQuery
     */
    public function getNotificationEmail()
    {
        //return NotificationEmail::find()->where(['programa_id' => $this->id]);
        return $this->hasMany(NotificationEmail::class, ['programa_id' => 'id']);
    }
    public function getNotificationPanel()
    {
      return $this->hasMany(NotificationPanel::class, ['programa_id' => 'id']);

    }

    public function getNotifications()
    {
        return $this->hasMany(Notification::class, ['programa_id' => 'id']);
    }

    /**
     * Obtiene las asignaturas de un programa
     * @return \yii\db\ActiveQuery
     */
    public function getAsignatura()
    {
        return $this->hasOne(Asignatura::class, ['id' => 'asignatura_id']);
    }

    /**
     * Obtiene los departamentos de un programa
     * @deprecated version 1
     * @return \yii\db\ActiveQuery
     */
    public function getDepartamento()
    {
        return $this->hasOne(Departamento::class, ['id' => 'departamento_id']);
    }

    public function getDepartamentoasignatura()
    {
      return $this->hasOne(Departamento::class, ['id' => 'departamento_id'])
        ->via('asignatura');
    }

    /**
     * Obtiene el estado de un programa
     * @return \yii\db\ActiveQuery
     */
    public function getStatus()
    {
        return $this->hasOne(Status::class, ['id' => 'status_id']);
    }

    /**
     * Obtiene las unidades de un programa
     * @return \yii\db\ActiveQuery
     * @deprecated
     */
    public function getUnidades()
    {
        return $this->hasMany(Unidad::class, ['programa_id' => 'id']);
    }

    /**
     * Obtiene el perfil del creador del programa
     * @return Perfil
     */
    public function getCreador()
    {
        return $this->hasOne(Perfil::class, ['user_id' => 'created_by'])->one();
    }
    /**
     * Obtiene el perfil del creador del programa
     * @return \yii\db\ActiveQuery
     */
    public function getPerfil()
    {
        return $this->hasOne(Perfil::class, ['user_id' => 'created_by']);
    }

    /**
     * Obtiene al creador del programa
     * @return Integer
     */
    public function getCreatedBy(){
      return $this->created_by;
    }

    /**
     * Obtiene la nomenclatura de la asignatura perteneciente al programa
     * @return String
     */
    public function getNomenclatura()
    {
      return $this->getAsignatura()->one()->getNomenclatura();
    }
    /**
     * Obtiene el curso del programa
     * @return Integer
     */
    public function getCurso()
    {
      return $this->getAsignatura()->one()->getCurso();
    }

    /**
     * @deprecated
     */
    public function getOrdenanza()
    {
        $plan = $this->getPlan()->one();
        if ($plan->root) {
            return $plan->root->getOrdenanza();
        }

        return $plan->getOrdenanza();
    }

    public function getCompleteOrdinance()
    {
        if (!$this->plan->root) {
            return 'Plan ' . $this->plan->getOrdenanza();
        }

        $rootPlan = $this->plan->root;
        $ordinance = 'Plan: ' . $rootPlan->getOrdenanza();

        $amendingPlan = '';
        $currentPlan = $rootPlan;

        while($currentPlan->child && $currentPlan->child->id != $this->plan->id) {
            $amendingPlan .= " " . $currentPlan->child->getOrdenanza() . " - ";
            $currentPlan = $currentPlan->child;
        }

        if ($currentPlan->child) {
            $amendingPlan .= " " . $currentPlan->child->getOrdenanza();
        }

        if ($amendingPlan) {
            $amendingPlan = ' - Modificatorias:' . rtrim($amendingPlan, '- ');
            $ordinance .= $amendingPlan;
        }

        return $ordinance;
    }

    public function getFundamentacion(){
      return $this->fundament;
    }

    public function getObjetivoPlan(){
      return $this->objetivo_plan;
    }

    public function getContenidoPlan(){
      return $this->contenido_plan;
    }

    public function getContenidoAnalitico(){
      return $this->contenido_analitico;
    }

    public function countContenidoAnalitico(){
      $unidades = $this->getUnidades()->count();
      return $unidades;
    }

    public function getPropuestaMetodologica(){
      return $this->propuesta_met;
    }

    public function getEyCAcreditacion(){
      return $this->evycond_acreditacion;
    }

    public function getParcRecyPromo(){
      return $this->parcial_rec_promo;
    }

    public function getDistHoraria(){
      return $this->distr_horaria;
    }

    public function getCronoTent(){
      return $this->crono_tentativo;
    }

    public function getActividadExtrac(){
      return $this->actv_extracur;
    }

    public function getYear(){
      return $this->year;
    }

    public function getEquipoCatedra(){
      return $this->equipo_catedra;
    }

    /**
     * obtiene el porcentaje de carga según 14 incisos.
     * si el inciso tiene más de 10 letras cuenta como completo
     * incluye etiquetas HTML
     * @return Integer
     */
    public function calcularPorcentajeCarga(){
      // valor x inciso
      $valorPunto = 100/14;

      $porcentaje = 0;
      if(strlen($this->getFundamentacion()) > 10){
        $porcentaje = $porcentaje+$valorPunto;
      }
      if(strlen($this->getObjetivoPlan()) > 10){
        $porcentaje = $porcentaje+$valorPunto;
      }
      if(strlen($this->getContenidoPlan()) > 10){
        $porcentaje = $porcentaje+$valorPunto;
      }
      if(strlen($this->getContenidoAnalitico()) > 10){
        $porcentaje = $porcentaje+$valorPunto;
      }
      if(strlen($this->getPropuestaMetodologica()) > 10){
        $porcentaje = $porcentaje+$valorPunto;
      }
      if(strlen($this->getEyCAcreditacion()) > 10){
        $porcentaje = $porcentaje+$valorPunto;
      }
      if(strlen($this->getParcRecyPromo()) > 10){
        $porcentaje = $porcentaje+$valorPunto;
      }
      if(strlen($this->getDistHoraria()) > 10){
        $porcentaje = $porcentaje+$valorPunto;
      }
      if(strlen($this->getCronoTent()) > 10){
        $porcentaje += $valorPunto;
      }
      if(strlen($this->getActividadExtrac()) > 10){
        $porcentaje += $valorPunto;
      }
      if(strlen($this->getObjetivoPrograma()) > 10){
        $porcentaje += $valorPunto;
      }
      if(strlen($this->getBibliografiaBasica()) > 10){
        $porcentaje += $valorPunto;
      }
      if(strlen($this->getEquipoCatedra()) > 10){
        $porcentaje += $valorPunto;
      }
      if(strlen($this->getFirma()) > 10){
        $porcentaje+= $valorPunto;
      }
      //redondear porcentaje
      return round($porcentaje);
    }

    public function hasMinimumLoadPercentage(): bool
    {
        return $this->calcularPorcentajeCarga() > self::MIN_LOAD_PERCENTAGE;
    }

    public function getObjetivoPrograma(){
      return $this->objetivo_programa;
    }
    public function getBibliografiaBasica(){
      return $this->biblio_basica;
    }
    public function getBibliografiaConsulta(){
      return $this->biblio_consulta;
    }
    /**
     * Cambia el estado del programa al siguiente según el peso (valor) que tenga el estado actual
     * Si pudo cambiar el estado devuelve true, en caso contrario, false.
     * @return Boolean
     */
    public function subirEstado():bool{
      $estadoActual = Status::findOne($this->status_id);
      if($estadoActual){
        $estadoSiguiente = $estadoActual->nextStatus();

        if (
            $estadoSiguiente &&
            $estadoActual->is(Status::BORRADOR_ID) &&
            $this->departamento_id
        ) {
            // super patch
            $estadoSiguiente = $estadoSiguiente->nextStatus();
        }

        if ($estadoSiguiente) {
            $this->status_id = $estadoSiguiente->id;
            return true;
        }
      }
      return false;
    }
    /**
     * Cambia el estado del programa al anterior según el peso (valor) que tenga el estado actual
     * Si pudo cambiar el estado devuelve true, en caso contrario, false.
     * @return Boolean
     */
    public function bajarEstado():bool{
      $estadoActual = Status::findOne($this->status_id);
      if($estadoActual){
        $estadoAnterior = $estadoActual->prevStatus();
        if ($estadoAnterior) {
            $this->status_id = $estadoAnterior->id;
            return true;
        }
      }
      return false;
    }
    /**
     * Cambia el estado manualmente
     * Si pudo cambiar el estado devuelve true, en caso contrario, false.
     * @return Boolean
     */
    public function setEstado($estado):bool {
      if (!isset($estado))
        return false;
      if ($estado == "Borrador"){
        $this->departamento_id = null;
      }
      $estadoModel = Status::find()->where(['=', 'descripcion',$estado])->one();
      if ($estadoModel) {
        $this->status_id = $estadoModel->id;
        return true;
      }
      return false;
    }
    /**
     * Traducción del valor de la variable curso.
     * Primer año : 1, Segundo año: 2, etc.
     * @return String
     */
    public function printCurso(){
      $string = "";
      switch ($this->curso) {
          case 1:
              $string = "Primer año";
              break;
          case 2:
              $string= "Segundo año";
              break;
          case 3:
              $string= "Tercer año";
              break;
          case 4:
              $string= "Cuarto año";
              break;
          case 5:
              $string= "Quinto año";
              break;
          case 6:
              $string= "Sexto año";
              break;
      }

      return $string.$this->curso;
    }
    public function getFirma(){
      return $this->firma;
    }
    public function setFirma($string) {
      $this->firma = $string;
    }

    public function setAsignatura($asignaturaID) {
      $this->asignatura_id = $asignaturaID;
    }
    /**
     * Obtiene el nombre de la asignatura y el plan para mostrarlo al usuario
     * @return String
     */
    public function mostrarAsignatura(){
      $asignatura = $this->getAsignatura()->one();
      $plan = $asignatura ? $asignatura->getPlan()->one() : null;
      $string = $asignatura ? $asignatura->getNomenclatura(): 'S/asginatura';
      $string = $plan ? $string." (".$plan->getOrdenanza().")" : $string;
      return $string;
    }

    public static function initNewProgram()
    {
        $model = new Programa();
        $model->scenario = 'crear';
        $model->fundament = '';
        $model->objetivo_plan = '';
        $model->objetivo_programa = '';
        $model->contenido_plan = '';
        $model->propuesta_met = '';
        $model->evycond_acreditacion = '';
        $model->parcial_rec_promo = '';
        $model->distr_horaria = '';
        $model->crono_tentativo = '';
        $model->actv_extracur = '';
        $model->status_id = Status::find()->where(['=', 'descripcion', 'Borrador'])->one()->id;
        return $model;

    }

    public function defineScenario($moduleType)
    {
        switch($moduleType) {
            case 'default':
                $this->scenario = 'default';
                break;
            case Module::TIME_DISTRIBUTION_TYPE:
                $this->scenario = 'dist-horaria';
                break;
            case Module::PROFESSORSHIP_TEAM_TYPE:
                $this->scenario = 'equipo_catedra';
                break;
            case Module::FUNDAMENTALS_TYPE:
                $this->scenario = 'fundamentacion';
                break;
            case Module::PLAN_OBJECTIVE_TYPE:
                $this->scenario = 'obj-plan';
                break;
            case Module::PROGRAM_OBJECTIVE_TYPE:
                $this->scenario = 'objetivo-programa';
                break;
            case Module::PLAN_CONTENT_TYPE:
                $this->scenario = 'cont-plan';
                break;
            case Module::ANALYTICAL_CONTENT_TYPE:
                $this->scenario = 'contenido_analitico';
                break;
            case Module::BIBLIOGRAPHY_TYPE:
                $this->scenario = 'bibliografia';
                break;
            case Module::METHOD_PROPOSAL_TYPE:
                $this->scenario = 'prop-met';
                break;
            case Module::EVALUATION_AND_ACCREDITATION_TYPE:
                $this->scenario = 'eval-acred';
                break;
            case Module::EXAMS_AND_PROMOTION_TYPE:
                $this->scenario = 'parc-rec-promo';
                break;
            case Module::TIMELINE_TYPE:
                $this->scenario = 'crono-tent';
                break;
            case Module::ACTIVITIES_TYPE:
                $this->scenario = 'actv-extra';
                break;
            case Module::SIGN_TYPE:
                $this->scenario = 'firma';
                break;
            default:
                throw new \Exception('Error, step not implemented');
                break;
        }
    }

    public function saveModuleData(Module $module) : bool
    {
        $moduleType = $module->type;
        $this->defineScenario($moduleType);
        switch($moduleType) {
            case Module::TIME_DISTRIBUTION_TYPE:
                $this->distr_horaria = $module->value;
                break;
            case Module::PROFESSORSHIP_TEAM_TYPE:
                $this->equipo_catedra = $module->value;
                break;
            case Module::FUNDAMENTALS_TYPE:
                $this->fundament = $module->value;
                break;
            case Module::PLAN_OBJECTIVE_TYPE:
                $this->objetivo_plan = $module->value;
                break;
            case Module::PROGRAM_OBJECTIVE_TYPE:
                $this->objetivo_programa = $module->value;
                break;
            case Module::PLAN_CONTENT_TYPE:
                $this->contenido_plan = $module->value;
                break;
            case Module::ANALYTICAL_CONTENT_TYPE:
                $this->contenido_analitico = $module->value;
                break;
            case Module::BIBLIOGRAPHY_TYPE:
                $this->biblio_basica = $module->value;
                break;
            case Module::METHOD_PROPOSAL_TYPE:
                $this->propuesta_met = $module->value;
                break;
            case Module::EVALUATION_AND_ACCREDITATION_TYPE:
                $this->evycond_acreditacion = $module->value;
                break;
            case Module::EXAMS_AND_PROMOTION_TYPE:
                $this->parcial_rec_promo = $module->value;
                break;
            case Module::TIMELINE_TYPE:
                $this->crono_tentativo = $module->value;
                break;
            case Module::ACTIVITIES_TYPE:
                $this->actv_extracur = $module->value;
                break;
            case Module::SIGN_TYPE:
                $this->firma = $module->value;
                break;


                //TODO: Agregar todos los modulos necesarios para guardar la data;
                /*
                    'equipo_catedra' => 'Equipo de catedra',
                 */
            default:
                throw new \Exception('Error, Modulo no encontrado');
                break;
        }

        return $this->save();
    }

    public function setDefaultValues($moduleType) : void
    {
        switch ($moduleType) {
            case Module::BIBLIOGRAPHY_TYPE:
                if ($this->biblio_basica == null) {
                    $this->biblio_basica = "<p><strong>Bibliograf&iacute;a b&aacute;sica</strong></p> <p>&nbsp;</p><p><strong>Bibliograf&iacute;a de consulta</strong></p>";
                }
                break;
            case Module::TIMELINE_TYPE:
                if ($this->crono_tentativo == null ) {
                    $this->crono_tentativo = '
                    <table style="border-collapse: collapse; height: 110px; border-color: black; border-style: solid; float: left;" border="1">
                      <tbody>
                      <tr style="height: 22px;">
                      <th style="width: 400.2px; height: 22px;" colspan="5">Cuatrimestre</th>
                      </tr>
                      <tr style="height: 44px;">
                      <th style="width: 106px; height: 44px;">Tiempo <br />/ Unidades</th>
                      <th style="width: 68px; height: 44px;">Marzo</th>
                      <th style="width: 53px; height: 44px;">Abril</th>
                      <th style="width: 61px; height: 44px;">Mayo</th>
                      <th style="width: 57px; height: 44px;">Junio</th>
                      </tr>
                      <tr style="height: 22px;">
                      <td style="width: 106px; height: 22px;">Unidad 1</td>
                      <td style="width: 68px; height: 22px;">X</td>
                      <td style="width: 53px; height: 22px;">&nbsp;</td>
                      <td style="width: 61px; height: 22px;">&nbsp;</td>
                      <td style="width: 57px; height: 22px;">&nbsp;</td>
                      </tr>
                      <tr style="height: 22px;">
                      <td style="width: 106px; height: 22px;">Unidad 2</td>
                      <td style="width: 68px; height: 22px;">&nbsp;</td>
                      <td style="width: 53px; height: 22px;">&nbsp;</td>
                      <td style="width: 61px; height: 22px;">&nbsp;</td>
                      <td style="width: 57px; height: 22px;">&nbsp;</td>
                      </tr>
                      </tbody>
                      </table>
                    ';
                }
                break;
            case Module::SIGN_TYPE:
                if($this->getFirma() == null){
                  $html =
                      '<div class="" style="text-align: center;">Firma del responsable <br />Aclaraci&oacute;n <br />Cargo</div>
                      <div class="" style="text-align: center;">&nbsp;</div>
                      <div class="" style="text-align: center;"><br />
                      <div class="" style="text-align: right;">Lugar y fecha de entrega</div>
                      </div>';
                  $this->setFirma($html);
                }
                break;

            default:
                break;
        }
    }

    public function getTimesDistributions()
    {
        $timesDistributions = null;

        if($this->year >= 2023){
            $module = Module::find()->oneByTimeDistributionTypeAndProgram($this->id);
            $timesDistributions = $module->timeDistributions;
        }

        return $timesDistributions;
    }

    public function delete()
    {
        $this->deleted_at = date('Y-m-d H:i:s');
        return $this->save(false);
    }
}
