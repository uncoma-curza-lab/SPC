<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Objetivo */

$this->title = 'Create Objetivo';
$this->params['breadcrumbs'][] = ['label' => 'Objetivos', 'url' => ['programa/objetivo-plan','id' => $modelObj->programa_id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="objetivo-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_formPrograma', [
        'modelObj' => $modelObj,
    ]) ?>

</div>
