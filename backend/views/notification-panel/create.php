<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Rol */

$this->title = 'Crear Not. Panel';
$this->params['breadcrumbs'][] = ['label' => 'Not. Panel', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="rol-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
