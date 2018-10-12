<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\ProgramaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Programas';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="programa-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Crear Programa', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
              'attribute' => 'departamento_id',
              'value' => function($data) {
                return $data->getDepartamento()->one()->nom;
              }
            ],
            'curso',
            'year',
            'cuatrimestre',
            //'profadj_regular',
            //'asist_regular',
            //'ayudante_p',
            //'ayudante_s',
            //'fundament',
            //'objetivo_plan',
            //'contenido_plan',
            //'propuesta_met',
            //'evycond_acreditacion',
            //'parcial_rec_promo',
            //'distr_horaria',
            //'actv_extracur',
            //'created_at',
            //'updated_at',
            //'created_by',
            //'updated_by',

            [
              'class' => 'yii\grid\ActionColumn',
              'template' => '{view}{update}{delete}{pdf}{status}',
              'buttons' => [
                'pdf' => function ($url,$model) {
                    return Html::a(
                        '<span style="padding:5px; font-size:20px;" class="glyphicon glyphicon-download"></span>',
                        ['export-pdf','id'=> $model->id],['target' => '_blank']);
                },
                'status' => function ($url,$model) {
                    return Html::a(
                        '<span style="padding:5px; font-size:20px;" class="glyphicon glyphicon-info-sign"></span>',
                        $url);
                },
                'view' => function ($url,$model) {
                    return Html::a(
                        '<span style="padding:5px; font-size:20px;" class="glyphicon glyphicon-eye-open"></span>',
                        $url);
                },
                'update' => function ($url,$model) {
                    return Html::a(
                        '<span style="padding:5px; font-size:20px;" class="glyphicon glyphicon-pencil"></span>',
                        $url);
                },
                'delete' => function ($url,$model) {
                    return Html::a(
                        '<span style="padding:5px; font-size:20px;" class="glyphicon glyphicon-trash"></span>',
                        $url,
                        [
                            'title' => Yii::t('yii', 'Delete'),
                            'data-confirm' => Yii::t('yii', 'Quiere eliminar el programa?'),
                            'data-method' => 'post',
                        ]
                    );
                },
              ]
            ],
        ],
    ]); ?>
</div>
