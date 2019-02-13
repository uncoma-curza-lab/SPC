<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;

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
                'confirm' => 'Desea borrar esto?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'departamento_id',
            'status_id',
            'asignatura_id',
            'year',

            /*'curso',
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
    <?= GridView::widget([
        'dataProvider' => $dataProvDesignacion,
        'filterModel' => $searchModelDesignacion,
        'columns' => [
            //['class' => 'yii\grid\SerialColumn'],

            'cargo_id',
            'user_id',

            //['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
