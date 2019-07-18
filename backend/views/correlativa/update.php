<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\CarreraPrograma */

$this->title = 'Actualización de correlativa: ';
$this->params['breadcrumbs'][] = ['label' => 'Correlativas', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Actualizar correlativa de asignatura ';
?>
<div class="carrera-programa-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
