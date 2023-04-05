<?php

namespace api\modules\v1\models;

use common\models\Departamento as ModelsDepartamento;
use yii\web\Link;
use yii\web\Linkable;
use yii\helpers\Url;

class Departamento extends ModelsDepartamento implements Linkable
{
    public function fields(){
        return [
            'id',
            'nombre' => 'nom',
            
        ];
    }
    public function extraFields() {

        return ['carreras' => function(){ return $this->getCarreras()->all();}];

    }
    public function getLinks(){
        return [
            Link::REL_SELF => Url::to(['departamento/'.$this->id], true),
            'carreras' => Url::to(['carrera/departamento','id' => $this->id], true),
        ];    
    }

}
