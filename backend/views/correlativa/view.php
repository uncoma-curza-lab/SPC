<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\CarreraPrograma */

//$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Carrera Programas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="carrera-programa-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update','asignatura_id' => $model->asignatura_id, 'correlativa_id' => $model->correlativa_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete','asignatura_id' => $model->asignatura_id, 'correlativa_id' => $model->correlativa_id], [
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
            'asignatura_id',
            'correlativa_id',
        ],
    ]) ?>

</div>
