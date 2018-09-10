<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Programa */

$this->title = 'Seguir Programa';
$this->params['breadcrumbs'][] = ['label' => 'Programas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="programa-page">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('forms/_form', [
        'model' => $model,
    ]) ?>

</div>
