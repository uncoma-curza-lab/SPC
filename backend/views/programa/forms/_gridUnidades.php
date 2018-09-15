<?php

use yii\helpers\Html;
use yii\grid\GridView;
use backend\models\Unidad;
use backend\models\UnidadSearch;
use yii\widgets\Pjax;
use yii\data\ActiveDataProvider;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\UnidadSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

?>
<div class="unidad-index">
    <?php Pjax::begin(); ?>
    <p>
        <?= Html::a('Create Unidad', ['unidad/create' , 'id' => $model->id], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => new ActiveDataProvider([
          'query' => $model->getUnidades()
        ]),
        'filterModel' => new UnidadSearch(),
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'descripcion',
            'biblio_basica',
            'biblio_consulta',
            'crono_tent',
            //'programa_id',

            [
              'class' => 'yii\grid\ActionColumn',
              'controller' => 'unidad'
            ],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
