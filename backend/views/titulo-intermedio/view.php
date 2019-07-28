<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\CarreraPrograma */

$this->title = "Relación entre titulo intermedio y una carrera";
$this->params['breadcrumbs'][] = ['label' => 'Carrera Programas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="carrera-programa-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'carrera' => $model->carrera_id, 'tituloIntermedio' => $model->titulo_intermedio_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'carrera' => $model->carrera_id, 'tituloIntermedio' => $model->titulo_intermedio_id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'carrera_id',
            'titulo_intermedio_id',
        ],
    ]) ?>

</div>
