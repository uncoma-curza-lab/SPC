<?php

namespace backend\models;

use Yii;
use yii\db\Expression;
use yii\behaviors\BlameableBehavior;
use yii\db\ActiveRecord;
use common\models\User;

/**
 * This is the model class for table "programa".
 *
 * @property int $id
 * @property int $departamento_id
 * @property int $status_id
 * @property string $asignatura
 * @property string $curso
 * @property string $year
 * @property int $cuatrimestre
 * @property string $profadj_regular
 * @property string $asist_regular
 * @property string $ayudante_p
 * @property string $ayudante_s
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
 * @property Objetivo[] $objetivos
 * @property Departamento $departamento
 * @property Status $status
 * @property Unidad[] $unidades
 */
class Programa extends \yii\db\ActiveRecord
{
    /**
    * @deprecated objetivos del programa
    */
    public $objetivos;
    public $unidades;
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
            [['departamento_id', 'status_id', 'cuatrimestre', 'created_by', 'updated_by'], 'integer'],

            //  [['asignatura', 'curso', 'profadj_regular', 'asist_regular', 'ayudante_p', 'ayudante_s', 'fundament', 'objetivo_plan', 'contenido_plan', 'propuesta_met', 'evycond_acreditacion', 'parcial_rec_promo', 'distr_horaria', 'crono_tentativo', 'actv_extracur'], 'required'],
            [['status_id'], function($attribute,$params){
              if ( $this->$attribute == 'Borrador') {
                $cont =0;
                $attributes_validates = [
                  'departamento_id', 'cuatrimestre', 'year',
                  'asignatura', 'curso', 'fundament'
                ];
                foreach ($attributes_validates as $key ) {
                  if (!isset($this->$key)){
                      $this->addError($attribute,"estado no posible");
                  }
                }
              }
            }],
            [[
              'year', 'status_id',
              'cuatrimestre', 'asignatura', 'curso',
               'fundament', 'objetivo_plan', 'contenido_plan',
               'propuesta_met', 'evycond_acreditacion', 'parcial_rec_promo',
               'distr_horaria', 'crono_tentativo', 'actv_extracur'
             ], 'required'],
            [['fundament', 'objetivo_plan', 'contenido_plan', 'propuesta_met', 'evycond_acreditacion', 'parcial_rec_promo', 'distr_horaria', 'crono_tentativo', 'actv_extracur'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['asignatura'], 'string', 'max' => 100],
//            [['curso', 'profadj_regular', 'asist_regular', 'ayudante_p', 'ayudante_s'], 'string', 'max' => 60],
            [['curso'], 'string', 'max' => 60],
            [['year'], 'string', 'max' => 4],
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

    public function scenarios(){
      $scenarios = parent::scenarios();
      $scenarios['crear'] = [
        'curso',
        'status_id',
        'cuatrimestre',
        'year',
        'asignatura'
      ];
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
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'departamento_id' => 'Departamento',
            'status_id' => 'Estado',
            'asignatura' => 'Asignatura',
            'curso' => 'Curso',
            'year' => 'Año',
            'cuatrimestre' => 'Cuatrimestre',
            //'profadj_regular' => 'Profesor adj. Regular',
            //'asist_regular' => 'Asistente Regular',
          //  'ayudante_p' => 'Ayudante Primera',
          //  'ayudante_s' => 'Ayudante Segunda',
            'fundament' => 'Fundamentacion',
            'objetivo_plan' => 'Objetivo del Plan',
            'contenido_plan' => 'Contenido del Plan',
            'propuesta_met' => 'Propuesta Metodologica',
            'evycond_acreditacion' => 'Evaluación y condiciones de acreditacion',
            'parcial_rec_promo' => 'Parciales, Recuperatorios y Promocios',
            'distr_horaria' => 'Distribución horaria',
            'crono_tentativo' => 'Cronograma Tentativo',
            'actv_extracur' => 'Actvidad Extracurricular',
            'created_at' => 'Se creó',
            'updated_at' => 'Se actualizó',
            'created_by' => 'Creado por',
            'updated_by' => 'Actualizado por',
        ];
    }

    /**
     * Obtiene todos los objetivos del programa
     * @return \yii\db\ActiveQuery
     */
    public function getObjetivos()
    {
        return $this->hasMany(Objetivo::className(), ['programa_id' => 'id']);
    }



    /**
     * Obtiene el estado del programa
     * @return \yii\db\ActiveQuery
     */
    public function getStatus()
    {
        return $this->hasOne(Status::className(), ['id' => 'status_id']);
    }

    /**
     * Obtiene las unidades del programa
     * @return \yii\db\ActiveQuery
     */
    public function getUnidades()
    {
        return $this->hasMany(Unidad::className(), ['programa_id' => 'id']);
    }
    /**
     * Obtiene los cargos del programa
     * @return \yii\db\ActiveQuery
     */
    public function getCargos()
    {
        return $this->hasMany(Cargo::className(), ['programa_id' => 'id']);
    }

    public function getCarrerap(){
      return $this->hasMany(CarreraPrograma::className(), ['programa_id' => 'id']);
    }
    public function getCarreras(){
      return $this->hasMany(Carrera::className(),['id' =>'carrera_id'])->via('carrerap');
    }


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'created_by']);
    }
}
