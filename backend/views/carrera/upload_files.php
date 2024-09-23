<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Subir archivo para la carrera: ' . $model->getCareerName(); // change to name
$this->params['breadcrumbs'][] = ['label' => 'Carreras', 'url' => ['index']];
//$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Upload file';

?>

<div class="career-upload-file">
    <h1><?= Html::encode($this->title) ?></h1>

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

        <?= $form->field($model, 'file')->fileInput()->label("Subir archivo") ?>

        <div class="form-group">
            <?= Html::submitButton('Subir', ['class' => 'btn btn-success']) ?>
        </div>

    <?php ActiveForm::end(); ?>
</div>
