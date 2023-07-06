<?php

namespace api\modules\v1\models;

use common\domain\programs\commands\GetAllByCourse\GetAllByCourseProcess;
use yii\web\Linkable;
use yii\web\Link;
use common\models\Asignatura as ModelsAsignatura;
use common\models\Status;
use yii\helpers\Url;

class Asignatura extends ModelsAsignatura implements Linkable
{
    private $version = "v1";

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
            $process = new GetAllByCourseProcess($this);
            $result = $process->handle();
            $programas = $result->getPrograms();

            $exports = [];
            
            if ($programas) {
                foreach($programas as $programa) {
                    if($programa->status_id == $bibliotecaId){
                        $exports[$programa->year] = Url::to(['biblioteca/download/' .  $programa->id], 'https');
                    }
                }
            }
            $withExports = true;
        }

        $responseLinks = [
            Link::REL_SELF => Url::to(['asignatura/' . $this->id], 'https'),
        ];    
        if ($withExports) {
            $responseLinks['exports'] = $exports;
        }
        return $responseLinks;
    }

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
}
