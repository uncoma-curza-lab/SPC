<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Observacion */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => $model->getPrograma()->one()->getAsignatura()->one()->nomenclatura, 'url' => ['programa/ver', 'id' => $model->programa_id]];
$this->params['breadcrumbs'][] = "Revisión de observación";
?>
<div class="observacion-view">
    <?= $model->texto ?>

    <!--<p>
        <? Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary disabled']) ?>
        <? Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger disabled',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <? DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'texto:ntext',
            'programa_id',
        ],
    ]) ?>-->

</div>
