<?php

use yii\helpers\Html;

use \yii\bootstrap\Collapse;
/* @var $this yii\web\View */
/* @var $model backend\models\Programa */

$this->title = 'Editar Programa';
$items = [];
$estadoPrograma = $model->getStatus()->one();
if($estadoPrograma->descripcion == "Borrador"){
  array_push($items,[
      'label' => 'Designaciones',
      'content' => [
        $this->render('forms/_gridDesignaciones',['model' => $model,]),
      ],

      'contentOptions' => ['class' => 'in',],
      /*'options' => [],
           'footer' => 'Footer' // the footer label in list-group
      ],*/
  ]);
} else if($estadoPrograma->descripcion == "Departamento"){
  array_push($items,[
      'label' => 'Programa',
      'content' => $this->render('pdf',['model' => $model]),
      'contentOptions' => [
        'class' => 'in',
        'style'=> 'overflow-y: scroll, height: auto;
               max-height: 320px;  overflow-x: hidden;',
      ],
      'visible' => false

  ]);
  array_push($items,[
      'label' => 'Observaciones',
      'contentOptions' => [],
      'content' =>   $this->render('forms/_gridObservaciones',['model' => $model]),
  ]);
  array_push($items,[
      'label' => 'Designaciones',
      'content' => [
        $this->render('forms/_gridDesignaciones',['model' => $model,]),
      ],

      'contentOptions' => [],
      /*'options' => [],
           'footer' => 'Footer' // the footer label in list-group
      ],*/
  ]);
}
?>

<?= Collapse::widget([
      'items' => $items]);
?>
