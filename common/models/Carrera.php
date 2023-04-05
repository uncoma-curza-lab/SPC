<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "carrera".
 *
 * @property int $id
 * @property string $nom
 * @property int $codigo
 * @property int $departamento_id
 *
 * @property Departamento $departamento
 */
class Carrera extends \yii\db\ActiveRecord
{

    private $version = "v1";

    public static function tableName()
    {
        return 'carrera';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nom'], 'required'],
            [['duracion_total_hs','departamento_id','nivel_id'], 'integer'],
            [['duracion_total_anos'],'number'],
            [['perfil','alcance','fundamentacion'],'string'],
            [['nom','titulo'], 'string', 'max' => 255],
            [['departamento_id'], 'exist', 'skipOnError' => true, 'targetClass' => Departamento::className(), 'targetAttribute' => ['departamento_id' => 'id']],
            [['nivel_id'], 'exist', 'skipOnError' => true, 'targetClass' => Nivel::className(), 'targetAttribute' => ['nivel_id' => 'id']],
            [['plan_vigente_id'], 'exist', 'skipOnError' => true, 'targetClass' => Plan::className(), 'targetAttribute' => ['plan_vigente_id' => 'id']],

        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'titulo' => 'Titulo',
            'alcance' => 'Alcance',
            'duracion_total_anos' => 'Duración en años',
            'duracion_total_hs' => 'Duración en horas',
            'perfil' => 'Perfil',
            'plan_vigente_id' => 'Plan vigente',
            'alcance' => 'Alcance',
            'fundamentacion' => 'Fundamentación',
            'nom' => 'Nombre',
            'departamento_id' => 'Departamento ID',
            'nivel_id' => 'Nivel ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPlanes()
    {
        return $this->hasMany(Plan::className(), ['carrera_id' => 'id']);
    }
    public function getCarreraModalidad()
    {
        return $this->hasMany(CarreraModalidad::className(), ['carrera_id' => 'id']);
    }
    public function getModalidades(){
        return $this->hasMany(Modalidad::className(), ['id' => 'modalidad_id'])
        ->viaTable('{{%carreramodalidad}}',['carrera_id'=>'id']);
    }

    public function getDepartamento()
    {
        return $this->hasOne(Departamento::className(), ['id' => 'departamento_id']);
    }

    public function getNivel()
    {
        return $this->hasOne(Nivel::className(), ['id' => 'nivel_id']);
    }

    public function getPlanVigente()
    {
        return $this->hasOne(Plan::className(), ['id' => 'plan_vigente_id']);
    }

    public function getNomenclatura()
    {
        return $this->nom;
    }

    public function getNivelID()
    {
        return $this->nivel_id;
    }

    public function getTituloIntermedio()
    {
        return $this->hasOne(TituloIntermedio::className(),['titulo_intermedio_id' => 'id']);
    }
}
