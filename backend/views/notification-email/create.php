<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Rol */

$this->title = 'Create Not. Email';
$this->params['breadcrumbs'][] = ['label' => 'Not. Email', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="rol-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
