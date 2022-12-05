<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\TimeDistribution */

$this->title = 'Create Time Distribution';
$this->params['breadcrumbs'][] = ['label' => 'Time Distributions', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="time-distribution-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
