<?php

namespace api\modules\v1\models;

use common\models\Carrera as ModelsCarrera;
use yii\web\Linkable;
use yii\web\Link;
use yii\helpers\Url;

class Carrera extends ModelsCarrera implements Linkable
{
    private $version = "v1";

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
                    $plan = $model->getPlanVigente()->with('root')->one();
                    if ($plan->root) {
                        $plan = $plan->root;
                    }
                }
                
                return $plan ? 
                    $plan
                    :
                    null;
            },
            'planes' => function($model){
                $planes = $model->getPlanes()->where(['=','plan.parent_id', null])->where(['activo' => true])->all();
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
            'planes' => Url::to(['plan/carrera','id' => $this->id], true),
        ];    
    }
}
