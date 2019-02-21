<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Estado */

$this->title = 'Creando un estado..';
$this->params['breadcrumbs'][] = ['label' => 'Estados', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="estado-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
