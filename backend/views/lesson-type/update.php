<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\LessonType */

$this->title = 'Update Lesson Type: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Lesson Types', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="lesson-type-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
