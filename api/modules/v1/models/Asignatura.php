<?php

namespace api\modules\v1\models;
use yii\web\Linkable;
use yii\web\Link;
use Yii;
use api\modules\v1\models\Departamento;
use common\models\Status;
use common\models\Correlativa;
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
            [['orden','curso', 'cuatrimestre', 'carga_horaria_sem', 'carga_horaria_cuatr', 'plan_id', 'departamento_id'], 'integer'],
            [['nomenclatura'], 'string', 'max' => 255],
            [['requisitos'],'string'],
            [['departamento_id'], 'exist', 'skipOnError' => true, 'targetClass' => Departamento::className(), 'targetAttribute' => ['departamento_id' => 'id']],
            [['plan_id'], 'exist', 'skipOnError' => true, 'targetClass' => Plan::className(), 'targetAttribute' => ['plan_id' => 'id']],
        ];
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
            /*'plan' => function(){
                return $this->plan_id ? 
                    Url::base(true)."/".$this->version."/plan/".$this->plan_id
                    :
                    null;
            }*/
            
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
            'requisitos' => 'Requisitos',
        ];
    }
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
            foreach($programas as $programa) {
                
                $exports[$programa->year][] = [
                    $programa->asignatura->plan->ordenanza => Url::to(['biblioteca/export/' .  $programa->id], true) 
                ];
            }
            $withExports = true;
        }

        $responseLinks = [
            Link::REL_SELF => Url::to(['asignatura/' . $this->id], true),
            //'edit' => Url::to(['user/view', 'id' => $this->id], true),
            //'planes' => Url::to(['planes/carrera','id' => $this->id], true),
            //'index' => Url::to(['dpto'], true),
        ];    
        if ($withExports) {
            $responseLinks['exports'] = $exports;
        }
        return $responseLinks;
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
      return $this->curso;
    }
    public function getCorrelativas()
    {
        return $this->hasMany(Correlativa::className(), ['asignatura_id' => 'id']);
    }
}
