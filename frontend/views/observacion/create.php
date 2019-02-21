<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Observacion */

$this->title = 'Agregar observacion';
$programa = $model->getPrograma()->one();
$this->params['breadcrumbs'][] = ['label' => isset($programa) ? $programa->getAsignatura()->one()->nomenclatura: null, 'url' => ['programa/ver', 'id' => $model->programa_id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="observacion-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
