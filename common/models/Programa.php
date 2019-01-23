<?php

namespace common\models;

use Yii;
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
            [[ 'fundament', 'objetivo_plan', 'contenido_plan', 'propuesta_met', 'evycond_acreditacion', 'parcial_rec_promo', 'distr_horaria', 'crono_tentativo', 'actv_extracur'], 'required'],
            [['fundament', 'objetivo_plan', 'contenido_plan', 'propuesta_met', 'evycond_acreditacion', 'parcial_rec_promo', 'distr_horaria', 'crono_tentativo', 'actv_extracur'], 'string'],
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
            'contenido_plan' => 'Contenido Plan',
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
      //  'year',
      ];
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
      return $scenarios;
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

    public function getNomenclatura()
    {
      return $this->getAsignatura()->one()->getNomenclatura();
    }
    public function getCurso()
    {
      return $this->getAsignatura()->one()->getCurso();
    }
}
