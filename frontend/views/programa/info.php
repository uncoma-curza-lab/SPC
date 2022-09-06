<?php

use yii\helpers\Html;
use common\models\PermisosHelpers;
use common\models\Status;
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
        'content'=>
                  $this->render('forms/_gridObservaciones',['model' => $model]),
        'visible' =>  PermisosHelpers::requerirSerDueno($model->id) ||
                      PermisosHelpers::requerirProfesorAdjunto($model->id) ||
                      PermisosHelpers::requerirDirector($model->id) ||
                      (
                        $estado_programa->descripcion == "Administración Académica" &&
                        PermisosHelpers::requerirRol('Adm_academica')
                      ) ||
                      (
                        $estado_programa->descripcion == "Secretaría Académica" &&
                        PermisosHelpers::requerirRol('Sec_academica')
                      ),
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
