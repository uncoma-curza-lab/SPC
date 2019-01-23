<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Programa */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Programas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="programa-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
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
            'id',
            'departamento_id',
            'status_id',
            'asignatura_id',
            /*'curso',
            'year',
            'cuatrimestre',
            'fundament:ntext',
            'objetivo_plan:ntext',
            'contenido_plan:ntext',
            'propuesta_met:ntext',
            'evycond_acreditacion:ntext',
            'parcial_rec_promo:ntext',
            'distr_horaria:ntext',
            'crono_tentativo:ntext',
            'actv_extracur:ntext',
            'created_at',
            'updated_at',
            'created_by',
            'updated_by',*/
        ],
    ]) ?>

</div>
