<?php

use yii\helpers\Html;
use yii\grid\GridView;
use common\models\Cargo;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\DepartamentoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Departamentos';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="departamento-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Departamento', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'nom',
            'slug',
            [
              'attribute'=> 'director',
              'value' => function($model){
                $cargoDirector = Cargo::find()->where(['=','nomenclatura','Director'])->one()->id;
                $designacion = $model->getDesignaciones()->where(['=','cargo_id',$cargoDirector])->one();
                if (!$designacion)
                  return "N/N";
                $perfil = $designacion->getPerfil()->one();
                return isset($perfil) ? $perfil->nombre ." ". $perfil->apellido  : "N/N";
              }
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
