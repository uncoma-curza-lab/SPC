<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Nivel */

$this->title = 'Crear Nivel';
$this->params['breadcrumbs'][] = ['label' => 'Niveles', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="nivel-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
