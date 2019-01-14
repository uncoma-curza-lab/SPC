<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Designacion */

$this->title = 'Create Designacion';
$this->params['breadcrumbs'][] = ['label' => 'Designacions', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="designacion-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
