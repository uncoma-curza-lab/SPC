<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Cargo */

$this->title = 'Crear Control Notification';
$this->params['breadcrumbs'][] = ['label' => 'Cargos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cargo-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
