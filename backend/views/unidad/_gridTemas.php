<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\data\ActiveDataProvider;
use yii\widgets\Pjax;
use backend\models\TemaSearch;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\TemaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

?>
<div class="tema-index">

    <?php Pjax::begin(); ?>

    <p>
        <?= Html::a('Create Tema', ['tema/create', 'id' => $model->id], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => new ActiveDataProvider([
          'query' => $model->getTemas()
        ]),
        'filterModel' => new TemaSearch(),
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'descripcion',
            'unidad_id',

            [
              'class' => 'yii\grid\ActionColumn',
              'controller' => 'tema'
            ],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
