<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\CarreraProgramaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
use common\models\Asignatura;
$this->title = 'Correlativas';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="correlativa-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Agregar Correlativa', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'attribute' => 'asignatura_id',
                'value' => function($model){
                    $asig = Asignatura::findOne($model->asignatura_id);
                    return $asig?
                        $asig->getNomenclatura()
                        :
                        null;
                }
            ],
            [
                'attribute' => 'correlativa_id',
                'value' => function($model){
                    $asig = Asignatura::findOne($model->correlativa_id);
                    return $asig?
                        $asig->getNomenclatura()
                        :
                        null;
                }
            ],

            [
                'class' => 'yii\grid\ActionColumn',
                'controller' => 'CarreraModalidadController',
                'template' => '{view} {update} {delete}',
                'buttons' => [
                    'update' => function ($url,$model) {
                          return Html::a(
                            '<span style="padding:5px; font-size:15px;" class="glyphicon glyphicon-pencil"></span>',
                            ['update','asignatura' => $model->asignatura_id,'correlativa' => $model->correlativa_id],
                            [
                                'title' => Yii::t('yii', 'Modificar equipo de cátedra'),
                            ]
                          );
                    },
                    'view' => function ($url,$model) {
                        return Html::a(
                          '<span style="padding:5px; font-size:15px;" class="glyphicon glyphicon-eye-open"></span>',
                          ['view','asignatura' => $model->asignatura_id,'correlativa' => $model->correlativa_id],
                          [
                              'title' => Yii::t('yii', 'Modificar equipo de cátedra'),
                          ]
                        );
                    },
                    'delete' => function ($url,$model) {
                        return Html::a(
                            '<span style="padding:5px; font-size:15px;" class="glyphicon glyphicon-trash"></span>',
                            ['delete','asignatura' => $model->asignatura_id,'correlativa' => $model->correlativa_id],
                            [
                                'data' => [
                                    'confirm' => Yii::t('app', 'borrar?'),
                                    'method' => 'post'
                                ]
                            ]
                        );
                    },
                ],
        
            ],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
