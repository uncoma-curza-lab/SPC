<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Status */

$this->title = 'Crear modalidad';
$this->params['breadcrumbs'][] = ['label' => 'Modalidades', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="modalidad-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
