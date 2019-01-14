<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\AsignaturaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Asignaturas';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="asignatura-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Asignatura', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'nomenclatura',
            'curso',
		         'cuatrimestre',
		         'carga_horaria_sem',
		         //'carga_horaria_cuatr',
		         'plan_id',
		         'departamento_id',


            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
