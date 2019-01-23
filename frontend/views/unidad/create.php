<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Unidad */

$this->title = 'Crear Unidad';
$this->params['breadcrumbs'][] = ['label' => 'Unidades', 'url' => ['programa/contenido-analitico','id' => $model->programa_id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="unidad-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
