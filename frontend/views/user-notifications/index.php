<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\TemaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Notificaciones';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tema-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    
    <p>
        <?= Html::a('Marcar todas como leídas', ['all-read'], ['class' => 'btn btn-info']) ?>
    </p>

    <?= \frontend\components\ShowNotifications::widget([
        'data' => $dataProvider,
        'columns' => [
            'read',
            'message'
        ]
    ]); ?>

    <?php Pjax::end(); ?>
</div>
