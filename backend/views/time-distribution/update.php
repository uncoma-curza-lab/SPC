<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\TimeDistribution */

$this->title = 'Update Time Distribution: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Time Distributions', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="time-distribution-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
