<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Tema */

$this->title = 'Actualizar tema: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Temas', 'url' => ['unidad/update','id' => $model->getUnidadId()]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="tema-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
