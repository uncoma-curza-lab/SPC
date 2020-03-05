<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\PlanSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Plans';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="plan-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Nuevo plan', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'planordenanza',
            [
                'attribute' => 'carrera_id',
                'value' => function($model){
                    $carrera = $model->getCarrera()->one();
                    
                    return $carrera ? $carrera->getNomenclatura() : "Sin carrera";
                    
                }
            ],

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => ' {view} {update} {delete} {upload} ',
                'buttons' => [
                    'upload' => function($url,$model) {
                        return Html::a(
                            '<span style="padding:5px;" class="glyphicon glyphicon-file"></span>',
                            ['upload','id' => $model->id],
                            [
                                'title' => Yii::t('yii', 'Subir archivo'),
                            ]
                          );
                    }
                ]

            ],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
