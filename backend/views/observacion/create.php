<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Observacion */

$this->title = 'Create Observacion';
$this->params['breadcrumbs'][] = ['label' => 'Observacions', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="observacion-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
