<?php

namespace api\modules\v1\models;

use common\models\Plan as ModelsPlan;
use yii\web\Link;
use yii\web\Linkable;
use yii\helpers\Url;

/**
 * This is the model class for table "plan".
 *
 * @property int $id
 * @property string $planordenanza
 * @property int $carrera_id
 *
 * @property Asignatura[] $asignaturas
 * @property Carrera $carrera
 */
class Plan extends ModelsPlan implements Linkable
{
    private $version = "v1";

    public function fields()
    {
        return [
            'id',
            'ordenanza' => 'planordenanza',
            'activo' => function($model) {
                return $model->activo ?
                    true : false;
            },
            'archivo' => function($model){
                return ($model->archivo ?\Yii::$app->urlManagerBackend->baseUrl.'/planFiles/'.$model->archivo  : '');
            },
        ];
    }

    public function getLinks(){
        $asignaturas = Url::to(['asignatura/plan','id' => $this->id], true) . '&withExport=1';
        return [
            Link::REL_SELF => Url::to(['plan/'.$this->id], true),
            'asignaturas' => $asignaturas,
        ];    
    }
    
    public function getOrdenanza(){
        return $this->planordenanza;
    }

    public function attributeLabels()
    {
        return [
            'id' => 'id',
            'planordenanza' => 'ordenanza',
            'carrera_id' => 'carrera_id',
            'archivo' => 'archivo',
        ];
    }

}
