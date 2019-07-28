<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\CarreraProgramaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
use common\models\Carrera;
$this->title = 'Modalidades por carrera';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cmodalidad-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Agregar modalidades', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'attribute' =>'carrera_id',
                'value' => function($model){
                    $carrera = Carrera::findOne($model->carrera_id);
                    return $carrera ? 
                        $carrera->getNomenclatura()
                        :
                        null;
                }
            ],
            [
                'attribute' =>'titulo_intermedio_id',
                'value' => function($model){
                    $tituloIntermedio = Carrera::findOne($model->titulo_intermedio_id);
                    return $tituloIntermedio ? 
                        $tituloIntermedio->getNomenclatura()
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
                            ['update','carrera' => $model->carrera_id,'tituloIntermedio' => $model->titulo_intermedio_id],
                            [
                                'title' => Yii::t('yii', 'Modificar equipo de cátedra'),
                            ]
                          );
                    },
                    'view' => function ($url,$model) {
                        return Html::a(
                          '<span style="padding:5px; font-size:15px;" class="glyphicon glyphicon-eye-open"></span>',
                          ['view','carrera' => $model->carrera_id,'tituloIntermedio' => $model->titulo_intermedio_id],
                          [
                              'title' => Yii::t('yii', 'Modificar equipo de cátedra'),
                          ]
                        );
                  },
                  'delete' => function ($url,$model) {
                    return Html::a(
                      '<span style="padding:5px; font-size:15px;" class="glyphicon glyphicon-trash"></span>',
                      ['delete','carrera' => $model->carrera_id,'tituloIntermedio' => $model->titulo_intermedio_id],
                      [
                        'title' => 'Borrar',
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
