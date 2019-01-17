<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use common\models\PermisosHelpers;
use common\models\EstadoHelpers;

use yii\widgets\DetailView;
use yii\bootstrap\card;
use backend\models\CarreraProgramaSearch;
use backend\models\Status;

use backend\models\CarreraPrograma;
use backend\models\Carrera;
use backend\models\Programa;
use yii\data\ActiveDataProvider;
use kartik\tabs\TabsX;

$show_this_nav = PermisosHelpers::requerirMinimoRol('Profesor');
$esAdmin = PermisosHelpers::requerirMinimoRol('Admin');
$estado_programa = Status::findOne(['=','id',$model->status_id]);


$mostrar = //(isset($estado_programa) && ($estado_programa->value > EstadoHelpers::getValue('Borrador')))
            (($estado_programa->descripcion == "Borrador" || $estado_programa->descripcion == "Departamento")
              && PermisosHelpers::requerirDirector($model->id))
            || ($estado_programa->descripcion == "Profesor"
              && PermisosHelpers::requerirProfesorAdjunto($model->id))
            || ($estado_programa->descripcion == "Administración Académica"
              && PermisosHelpers::requerirRol('Adm_academica'))
            || ($estado_programa->descripcion == "Secretaría Académica"
              && PermisosHelpers::requerirRol('Sec_academica'))
            || $esAdmin;
$items = [
    [
      'label' => 'Programa',
      'content' => $this->render('pdf',['model' => $model]),
      'active'=>true,
    ],
    [
        'label'=>'<i class="fas fa-home"></i> Observaciones',
        'content'=>// if (PermisosHelpers::requerirMinimoRol('Departamento'))
                  $this->render('forms/_gridObservaciones',['model' => $model]),
        'visible' =>  PermisosHelpers::requerirProfesorAdjunto($model->id)
                      || PermisosHelpers::requerirDirector($model->id),
    ],
    [
        'label' => 'Designación de Cargos',
        'content' => $this->render('forms/_gridDesignaciones',['model' => $model,]),
        'visible' =>  PermisosHelpers::requerirProfesorAdjunto($model->id)
                      || PermisosHelpers::requerirDirector($model->id),
    ],

]; ?>
<h1>Programa de <?= Html::encode($model->getAsignatura()->one()->nomenclatura)?> <br></h1>
<h2> Está siendo evaluado por: <?= Html::encode(Status::findOne($model->status_id)->descripcion)?></h2>

<?=  TabsX::widget([
    'items'=>$items,
    'position'=>TabsX::POS_ABOVE,
    //'align'=>TabsX::ALIGN_CENTER,
    'height' => TabsX::SIZE_MEDIUM,
    'bordered'=>true,
    'encodeLabels'=>false,

    'enableStickyTabs' => true,
    'stickyTabsOptions' => [
        'selectorAttribute' => 'data-target',
        'backToTop' => true,

    ],
]); ?>


  <div class="col-xs-6">
    <!-- <?php if ( PermisosHelpers::requerirMinimoRol('Departamento') ) : ?>
      <h3>Observaciones</h3>
        <?= $this->render('forms/_gridObservaciones',['model' => $model]) ?>
    <?php endif; ?> -->
  </div>
