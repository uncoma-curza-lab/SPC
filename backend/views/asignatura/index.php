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
        <?= Html::a('Nueva Asignatura', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'nomenclatura',
            [ 
                'attribute' => 'curso',
                'value' => function($model){
                    return $model->getCurso();
                }
            ],
            [ 
                'attribute' => 'cuatrimestre',
                'value' => function($model){
                    return $model->getCuatrimestre();
                }
            ],
	    [ 
                'attribute' =>  'carga_horaria_sem',
                'value' => function($model){
                    return $model->getCargaHorariaSem() ? $model->getCargaHorariaSem() : "N/N";
                }
               
            ],
            [ 
                'attribute' =>  'carga_horaria_cuatr',
                'value' => function($model){
                    return $model->getCargaHorariaCuatr() ? $model->getCargaHorariaCuatr(): "N/N";
                }
               
            ],
            [ 
                'attribute' => 'plan_id',
                'value' => function($model){
                    $plan = $model->getPlan()->one();
                    return $plan ? $plan->getOrdenanza() : "Sin plan";
                }
            ],
            [ 
                'attribute' => 'departamento_id',
                'value' => function($model){
                    $dpto = $model->getDepartamento()->one();
                    return $dpto ? $dpto->getNomenclatura() : "Sin Departamento";
                }
            ],


            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
