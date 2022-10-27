<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\LessonType */

$this->title = 'Create Lesson Type';
$this->params['breadcrumbs'][] = ['label' => 'Lesson Types', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="lesson-type-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
