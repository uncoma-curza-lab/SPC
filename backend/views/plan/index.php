<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\PlanSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Planes';
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
                'attribute' => 'carrera',
                'value' => function($model){
                    $carrera = $model->getCarrera()->one();
                    
                    return $carrera ? $carrera->getNomenclatura() : "Sin carrera";
                    
                }
            ],

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => ' <div style="text-align:center">{view} {update} {delete} {upload} {copy} </div>',
                'buttons' => [
                    'upload' => function($url,$model) {
                        if ($model->archivo == null || $model->archivo == "" ){
                            $iconString = '<span style="padding:5px;" class="glyphicon glyphicon-cloud-upload"></span>';

                        } else {
                            $iconString = '<span style="padding:5px;" class="glyphicon glyphicon-open-file"></span>';

                        }
                        return Html::a(
                            $iconString,
                            ['upload','id' => $model->id],
                            [
                                'title' => Yii::t('yii', 'Subir archivo'),
                            ]
                          );
                    },
                    'copy' => function($url,$model) {
                        return Html::a(
                            '<span style="padding:5px;" class="glyphicon glyphicon-copy"></span>',
                            ['copy','id' => $model->id],
                            [
                                'title' => Yii::t('yii', 'Copiar plan'),
                            ]
                          );
                    }
                ]

            ],

        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
