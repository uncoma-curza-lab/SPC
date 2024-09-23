<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\CarreraSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Carreras';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="carrera-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Nueva carrera', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'nom',
            [
                'attribute' => 'departamento_id',
                'value' => function ($model){
                    $depto = $model->getDepartamento()->one();
                    return $depto ? $depto->getNomenclatura() : "Sin departamento";
                }
            ],
            'codigo',
            [
                'attribute' => 'plan_vigente_id',
                'value' => function($model){
                    $plan = $model->getPlanVigente()->one();
                    return $plan ? $plan->getOrdenanza() : "N/N/";
                }
            ],

[
            'class' => 'yii\grid\ActionColumn',
            'template' => '{view} {update} {delete} {upload}',
            'buttons' => [
                'upload' => function ($url, $model, $key) {
                    return \yii\helpers\Html::a(
                        '<span class="glyphicon glyphicon-upload"></span>',
                        \yii\helpers\Url::to(['carrera-files/upload', 'id' => $model->id]),
                        [
                            'title' => 'Subir archivo',
                            'aria-label' => 'Subir archivo',
                            'data-pjax' => '0'
                        ]
                    );
                }
            ],
        ],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
