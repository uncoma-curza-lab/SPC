<?php

use yii\helpers\Html;
use common\models\PermisosHelpers;
use common\models\Status;
use kartik\tabs\TabsX;

$show_this_nav = PermisosHelpers::requerirMinimoRol('Profesor');
$esAdmin = PermisosHelpers::requerirMinimoRol('Admin');
$estado_programa = Status::findOne(['=','id',$model->status_id]);

$visible = PermisosHelpers::requerirSerDueno($model->id) ||
    PermisosHelpers::requerirProfesorAdjunto($model->id) ||
    PermisosHelpers::requerirDirector($model->id) ||
    PermisosHelpers::requerirAuxDepartamento($model) ||
    (
      $estado_programa->descripcion == "Administración Académica" &&
      PermisosHelpers::requerirRol('Adm_academica')
    ) ||
    (
      $estado_programa->descripcion == "Secretaría Académica" &&
      PermisosHelpers::requerirRol('Sec_academica')
    );

$items = [
    [
      'label' => 'Programa',
      'content' => $this->render('pdf',['model' => $model, 'timesDistributions' => $timesDistributions]),
      'active'=>true,
    ],
    [
        'label'=>'<i class="fas fa-home"></i> Observaciones',
        'content'=>
                  $this->render('forms/_gridObservaciones',['model' => $model]),
        'visible' =>  $visible,
    ],
]; ?>

<h3>Programa de <?= Html::encode($model->getAsignatura()->one()->nomenclatura)?> <br></h3>
<h4> Está siendo evaluado por: <?= Html::encode(Status::findOne($model->status_id)->descripcion)?></h4>

<?=  TabsX::widget([
    'items'=>$items,
    'position'=>TabsX::POS_ABOVE,
    //'align'=>TabsX::ALIGN_CENTER,
    'height' => TabsX::SIZE_LARGE,
    'bordered'=>true,
    'encodeLabels'=>false,

    'enableStickyTabs' => true,
    'stickyTabsOptions' => [
        'selectorAttribute' => 'data-target',
        'backToTop' => true,

    ],
]); ?>
