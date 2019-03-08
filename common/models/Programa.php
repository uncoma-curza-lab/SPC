<?php

namespace common\models;

use Yii;
use frontend\models\Perfil;
//behaviors library
use yii\db\Expression;
use yii\behaviors\BlameableBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "programa".
 *
 * @property int $id
 * @property int $departamento_id
 * @property int $status_id
 * @property int $asignatura_id
 * @property string $curso
 * @property int $year
 * @property int $cuatrimestre
 * @property string $fundament
 * @property string $objetivo_plan
 * @property string $contenido_plan
 * @property string $propuesta_met
 * @property string $evycond_acreditacion
 * @property string $parcial_rec_promo
 * @property string $distr_horaria
 * @property string $crono_tentativo
 * @property string $actv_extracur
 * @property string $created_at
 * @property string $updated_at
 * @property int $created_by
 * @property int $updated_by
 *
 * @property Carreraprograma[] $carreraprogramas
 * @property Designacion[] $designacions
 * @property Objetivo[] $objetivos
 * @property Observacion[] $observacions
 * @property Asignatura $asignatura
 * @property Departamento $departamento
 * @property Status $status
 * @property Unidad[] $unidads
 */
class Programa extends \yii\db\ActiveRecord
{
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
            [['departamento_id', 'status_id', 'asignatura_id', 'year', 'created_by', 'updated_by'], 'integer'],
            [['asignatura_id','year'], 'required', 'on' => 'crear', 'message'=>"Debe completar este campo"],
            //[['fundament'], 'required', 'on' => 'fundamentacion', 'message'=>"Debe completar este campo"],
            [['biblio_basica','objetivo_programa','contenido_analitico','fundament', 'objetivo_plan', 'contenido_plan', 'propuesta_met', 'evycond_acreditacion', 'parcial_rec_promo', 'distr_horaria', 'crono_tentativo', 'actv_extracur'], 'required','message'=>"Debe completar este campo"],
            [['equipo_catedra'],'required','on' => 'equipo_catedra','message' => "Debe completar este campo"],
            [['biblio_basica','biblio_consulta','equipo_catedra','contenido_analitico','fundament', 'objetivo_plan', 'contenido_plan', 'propuesta_met', 'evycond_acreditacion', 'parcial_rec_promo', 'distr_horaria', 'crono_tentativo', 'actv_extracur'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['asignatura_id'], 'exist', 'skipOnError' => true, 'targetClass' => Asignatura::className(), 'targetAttribute' => ['asignatura_id' => 'id']],
            [['departamento_id'], 'exist', 'skipOnError' => true, 'targetClass' => Departamento::className(), 'targetAttribute' => ['departamento_id' => 'id']],
            [['status_id'], 'exist', 'skipOnError' => true, 'targetClass' => Status::className(), 'targetAttribute' => ['status_id' => 'id']],
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
            'class' => BlameableBehavior::className(),
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
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
        ];
    }

    public function scenarios(){
      $scenarios = parent::scenarios();
      $scenarios['carrerap'] = ['status_id'];
      $scenarios['crear'] = [
      //  'curso',
        'asignatura_id',
      //  'cuatrimestre',
        'equipo_catedra',
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
      return array_merge(parent::scenarios(), $scenarios);
      //return $scenarios;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCarreraprogramas()
    {
        return $this->hasMany(Carreraprograma::className(), ['programa_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDesignaciones()
    {
        return $this->hasMany(Designacion::className(), ['programa_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getObjetivos()
    {
        return $this->hasMany(Objetivo::className(), ['programa_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getObservaciones()
    {
        return $this->hasMany(Observacion::className(), ['programa_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAsignatura()
    {
        return $this->hasOne(Asignatura::className(), ['id' => 'asignatura_id']);
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
    public function getStatus()
    {
        return $this->hasOne(Status::className(), ['id' => 'status_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUnidades()
    {
        return $this->hasMany(Unidad::className(), ['programa_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCreador()
    {
        return $this->hasOne(Perfil::className(), ['user_id' => 'created_by'])->one();
    }

    public function getNomenclatura()
    {
      return $this->getAsignatura()->one()->getNomenclatura();
    }
    public function getCurso()
    {
      return $this->getAsignatura()->one()->getCurso();
    }
    public function getOrdenanza(){
      return $this->getAsignatura()->one()->getPlan()->one()->getOrdenanza();
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
    public function calcularPorcentajeCarga(){
      $valorPunto = 100/13;

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
      return round($porcentaje);
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
    public function subirEstado():bool{
      $estadoActual = Status::findOne($this->status_id);
      if($estadoActual){
        $estadoSiguiente = Status::find()->where(['>','value',$estadoActual->value])->orderBy('value')->one();
        if ($estadoSiguiente) {
            $this->status_id = $estadoSiguiente->id;
            return true;
        }
      }
      return false;
    }
    public function bajarEstado():bool{
      $estadoActual = Status::findOne($this->status_id);
      if($estadoActual){
        $estadoAnterior = Status::find()->where(['<','value',$estadoActual->value])->orderBy('value DESC')->one();
        if ($estadoAnterior) {
            $this->status_id = $estadoAnterior->id;
            return true;
        }
      }
      return false;
    }
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
    public function printCurso(){
      $string = "";
      switch ($this->curso) {
          case 1:
              $string = "primer";
              break;
          case 2:
              $string= "segundo";
              break;
          case 3:
              $string= "tercer";
              break;
          case 4:
              $string= "cuarto";
              break;
          case 5:
              $string= "quinto";
              break;
          case 6:
              $string= "sexto";
              break;
      }
      $string = $string . " año";
      return $string;
    }

}
