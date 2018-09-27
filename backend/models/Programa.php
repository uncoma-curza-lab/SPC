<?php

namespace backend\models;

use Yii;

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
            // se comentan los campos requeridos (DEV)
            //  [['asignatura', 'curso', 'profadj_regular', 'asist_regular', 'ayudante_p', 'ayudante_s', 'fundament', 'objetivo_plan', 'contenido_plan', 'propuesta_met', 'evycond_acreditacion', 'parcial_rec_promo', 'distr_horaria', 'crono_tentativo', 'actv_extracur'], 'required'],
            [['fundament', 'objetivo_plan', 'contenido_plan', 'propuesta_met', 'evycond_acreditacion', 'parcial_rec_promo', 'distr_horaria', 'crono_tentativo', 'actv_extracur'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['asignatura'], 'string', 'max' => 100],
            [['curso', 'profadj_regular', 'asist_regular', 'ayudante_p', 'ayudante_s'], 'string', 'max' => 60],
            [['year'], 'string', 'max' => 4],
            [['departamento_id'], 'exist', 'skipOnError' => true, 'targetClass' => Departamento::className(), 'targetAttribute' => ['departamento_id' => 'id']],
            [['status_id'], 'exist', 'skipOnError' => true, 'targetClass' => Status::className(), 'targetAttribute' => ['status_id' => 'id']],
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
            'asignatura' => 'Asignatura',
            'curso' => 'Curso',
            'year' => 'Año',
            'cuatrimestre' => 'Cuatrimestre',
            'profadj_regular' => 'Profesor adj. Regular',
            'asist_regular' => 'Asistente Regular',
            'ayudante_p' => 'Ayudante Primera',
            'ayudante_s' => 'Ayudante Segunda',
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
     * Obtiene el departamento al que pertenece
     * @return \yii\db\ActiveQuery
     */
    public function getDepartamento()
    {
        return $this->hasOne(Departamento::className(), ['id' => 'departamento_id']);
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
}
