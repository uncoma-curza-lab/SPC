<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Unidad */
$programa = $model->getPrograma()->one();
$this->title = 'Añadiendo una unidad al programa: ';
$this->params['breadcrumbs'][] = ['label' => 'Unidades', 'url' => ['programa/contenido-analitico','id' => $model->programa_id]];
$this->params['breadcrumbs'][] = $this->title;
$porcentaje = $programa->calcularPorcentajeCarga();
?>
<div class="unidad-create">
  <div class="row">
    <div class="col-md-2 text-right">
      <label>Programa completado: </label>
    </div>
    <div class="col-md-10 ">
      <div class="progress">
        <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="<?= $porcentaje ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?= $porcentaje ?>%">
           <?= $porcentaje ?>%
        </div>
      </div>
    </div>
  </div>

    <h3><?= Html::encode($this->title) ?> <i> <?= Html::encode($programa->getAsignatura()->one()->getNomenclatura()." ".$programa->getYear()) ?></i></h3>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
