<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Plan */

$this->title = 'Copiar Plan';
$this->params['breadcrumbs'][] = ['label' => 'Planes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="plan-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>


</div>
