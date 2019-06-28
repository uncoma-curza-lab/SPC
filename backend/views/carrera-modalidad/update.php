<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\CarreraPrograma */

$this->title = 'Actulizando la modalidad de la carrera: ' . $model->carrera_id;
$this->params['breadcrumbs'][] = ['label' => 'Carrera Programas', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->carrera_id, 'url' => ['view', 'carrera' => $model->carrera_id,'modalidad' => $model->modalidad_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="carrera-programa-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
