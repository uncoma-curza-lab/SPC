<?php

namespace api\modules\v1\models;

use common\models\Designacion;
use common\models\Objetivo;
use common\models\Observacion;
use common\models\Programa as ModelsPrograma;
use common\models\Status;
//behaviors library
use yii\web\Link;
use yii\helpers\Url;
use yii\web\Linkable;

/**
 * This is the model class for table "programa".
 *
 * @property int $id
 * @property int $departamento_id
 * @property int $status_id
 * @property int $asignatura_id
 * @property string $curso
 * @property int $year
 * @property int $cuatrimestre
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
 * @property Carreraprograma[] $carreraprogramas
 * @property Designacion[] $designacions
 * @property Objetivo[] $objetivos
 * @property Observacion[] $observacions
 * @property Asignatura $asignatura
 * @property Departamento $departamento
 * @property Status $status
 * @property Unidad[] $unidads
 */
class Programa extends ModelsPrograma implements Linkable
{

  public function fields()
  {
    return [
      'id',
      'departamento' => 'departamento_id',
      'asignatura' => 'asignatura'
      /*'carrera' => function(){
            return $this->carrera_id ? 
                Url::base(true)."/".$this->version."/carrera/".$this->carrera_id
                :
                null;
        }*/
    ];
  }

  public function getLinks()
  {
    return [
      Link::REL_SELF => Url::to(['biblioteca/' . $this->id], 'https'),
      'export' => Url::to(['biblioteca/export/' . $this->id], 'https'),
    ];
  }
}
