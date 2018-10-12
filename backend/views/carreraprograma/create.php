<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\CarreraPrograma */

$this->title = 'Create Carrera Programa';
$this->params['breadcrumbs'][] = ['label' => 'Carrera Programas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="carrera-programa-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
