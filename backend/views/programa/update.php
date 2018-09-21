<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Programa */

$this->title = ' ' ;
$this->params['breadcrumbs'][] = ['label' => 'Programas', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->getDepartamento()->one()->nom . " " . $model->curso, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Portada';
?>
<div class="programa-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
