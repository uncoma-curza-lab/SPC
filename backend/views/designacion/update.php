<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Designacion */

$this->title = 'Update Designacion: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Designacions', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="designacion-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
