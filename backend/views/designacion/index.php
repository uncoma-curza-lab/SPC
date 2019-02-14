<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\DesignacionSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Designacions';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="designacion-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Designacion', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            [
              'attribute'=> 'cargo_id',
              'value' => function($model){
                $cargo = $model->getCargo()->one();
                return isset($cargo) ? $cargo->nomenclatura : "N/N/";
              }
            ],
            [
              'attribute'=> 'perfil_id',
              'value' => function($model){
                $perfil = $model->getPerfil()->one();
                return isset($perfil) ? $perfil->nombre . " " . $perfil->apellido : "N/N/";
              }
            ],
            'programa_id',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
