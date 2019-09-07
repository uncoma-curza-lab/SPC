<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Designacion */

$this->title = 'Actualizar DB Elastic';
$this->params['breadcrumbs'][] = ['label' => 'Elastic', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="elastic-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form') ?>

</div>
