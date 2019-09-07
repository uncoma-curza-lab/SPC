<?php

namespace api\modules\v1\models;
use yii\web\Linkable;
use yii\web\Link;
use common\models\CarreraModalidad;
use common\models\TituloIntermedio;
use Yii;
use yii\helpers\Url;
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
class Carrera extends \yii\db\ActiveRecord implements Linkable
{
    private $version = "v1";
    /**
     * {@inheritdoc}
     */
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
            [['duracion_total_hs','departamento_id'], 'integer'],
            [['duracion_total_anos'],'number'],
            [['perfil','alcance','fundamentacion'],'string'],
            [['nom','titulo'], 'string', 'max' => 255],
            [['departamento_id'], 'exist', 'skipOnError' => true, 'targetClass' => Departamento::className(), 'targetAttribute' => ['departamento_id' => 'id']],
            [['plan_vigente_id'], 'exist', 'skipOnError' => true, 'targetClass' => Plan::className(), 'targetAttribute' => ['plan_vigente_id' => 'id']],

        ];
    }

    public function fields(){
        return [
            'id',
            'nombre' => 'nom',
            'titulo' => 'titulo',
            'alcance' => 'alcance',
            'duracion_total_anos' => 'duracion_total_anos',
            'duracion_total_hs' => 'duracion_total_hs',
            'perfil' => 'perfil',
            'modalidades' => function ($model) {
                $modalidades = $model->getCarreraModalidad()->with(['modalidad'])->all();
                $array = [];
                foreach($modalidades as $modalidad){
                    $maux = $modalidad->getModalidad()->one();
                    if ($maux){
                        array_push($array,[
                            'nombre' => $maux->getNombre(),
                            'descripcion' => $maux->getDescripcion(),
                        ]);
                    }
                }

                return $array ? 
                    $array
                    :
                    null;
            },
            'plan_vigente' => function($model){
                $plan = null;
                if ($model->plan_vigente_id){
                    $plan = $model->getPlanVigente()->one();
                }
                
                return $plan ? 
                    //Url::to(['plan/'.$model->plan_vigente_id], true)
                    $plan
                :
                    null;
            },
            'planes' => function($model){
                $planes = $model->getPlanes()->where(['activo' => true])->all();
                return $planes;
            },
            'departamento' => function(){
                /*return $this->departamento_id ? 
                    Url::base(true)."/".$this->version."/dpto/".$this->departamento_id
                    :
                    null;*/
                return $this->departamento_id ? 
                    [
                        'nombre' => $this->getDepartamento()->one()->getNombre(),
                        'href' => Url::base(true)."/".$this->version."/departamento/".$this->departamento_id
                    ]: null;
            },
            'es_titulo_intermedio' => function($model){
                $modelo = $model->getTituloIntermedio()->one();
                return $modelo ? true : false;
            }
        ];
    }

    public function departamento($id){
        return ["nombre" => $id];
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
            'modalidad_id' => 'Modalidad'
        ];
    }
    public function getLinks(){
        return [
            Link::REL_SELF => Url::to(['carrera/'.$this->id], true),
            //'edit' => Url::to(['user/view', 'id' => $this->id], true),
            'planes' => Url::to(['plan/carrera','id' => $this->id], true),
            //'index' => Url::to(['dpto'], true),
        ];    
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPlanes()
    {
        return $this->hasMany(Plan::className(), ['carrera_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDepartamento()
    {
        return $this->hasOne(Departamento::className(), ['id' => 'departamento_id']);
    }
    
    public function getCarreraModalidad(){
        return $this->hasMany(CarreraModalidad::className(), ['carrera_id' => 'id']);
    }
    public function getPlanVigente(){
        return $this->hasOne(Plan::className(),['id' => 'plan_vigente_id']);
    }
    public function getTituloIntermedio(){
        return $this->hasOne(TituloIntermedio::className(),['titulo_intermedio_id' => 'id']);
    }
}
