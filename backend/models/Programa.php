<?php

namespace backend\models;

use Yii;
use yii\web\NotFoundHttpException;

/**
 * This is the model class for table "programa".
 *
 * @property int $id
 * @property int $departamento_id
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
 * @property string $actv_extracur
 * @property string $created_at
 * @property string $updated_at
 * @property int $created_by
 * @property int $updated_by
 *
 * @property Departamento $departamento
 */
class Programa extends \yii\db\ActiveRecord
{
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
            [['departamento_id', 'cuatrimestre', 'created_by', 'updated_by'], 'integer'],
          //  [['curso', 'profadj_regular', 'asist_regular', 'ayudante_p', 'ayudante_s', 'fundament', 'objetivo_plan', 'contenido_plan', 'propuesta_met', 'evycond_acreditacion', 'parcial_rec_promo', 'distr_horaria', 'actv_extracur'], 'required'],
            //[['unidades'] ,'validateUnidades'],
            [['created_at', 'updated_at'], 'safe'],
            [['curso', 'profadj_regular', 'asist_regular', 'ayudante_p', 'ayudante_s'], 'string', 'max' => 60],
            [['year'], 'string', 'max' => 4],
            [['fundament', 'objetivo_plan', 'contenido_plan', 'propuesta_met', 'evycond_acreditacion', 'parcial_rec_promo', 'distr_horaria', 'actv_extracur'], 'string', 'max' => 255],
            [['departamento_id'], 'exist', 'skipOnError' => true, 'targetClass' => Departamento::className(), 'targetAttribute' => ['departamento_id' => 'id']],
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
            'curso' => 'Curso',
            'year' => 'Año',
            'cuatrimestre' => 'Cuatrimestre',
            'profadj_regular' => 'Profesor adjunto regular',
            'asist_regular' => 'Asistente Regular',
            'ayudante_p' => 'Ayudante primera',
            'ayudante_s' => 'Ayudante segunda',
            'fundament' => 'Fundamentos',
            'objetivo_plan' => 'Objetivo de Plan',
            'contenido_plan' => 'Contenido Plan',
            'propuesta_met' => 'Propuesta Met',
            'evycond_acreditacion' => 'Evycond Acreditacion',
            'parcial_rec_promo' => 'Parcial Rec Promo',
            'distr_horaria' => 'Distribución Horaria',
            'actv_extracur' => 'Actvividades Extracurriculares',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDepartamento()
    {
        return $this->hasOne(Departamento::className(), ['id' => 'departamento_id']);
    }

    public function getObjetivos()
    {
        return $this->hasMany(Objetivo::className(), ['programa_id' => 'id']);
    }
    public function getUnidades()
    {

        return $this->hasMany(Unidad::className(), ['programa_id' => 'id']);
    }
    public function validateUnidades($attribute){
      $items = $this->$attribute;
      if(!is_array($items)){
        $this->addError("Error no es arreglo");
      }
      foreach ($items as $key => $value) {
        if($key=='unidades'){
            if(strlen($value['descripcion'])<30){
              $this->addError( 'The city must be either "London" or "Paris".');
            //  throw new NotFoundHttpException('The requested page does not exist.');

            }
        }

      }
    }
}
