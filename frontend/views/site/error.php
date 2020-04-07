<?php

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

use yii\helpers\Html;

$this->title = $name;
?>
<div class="site-error">

    <h1><?= Html::encode($this->title) ?></h1>
    <div class="alert alert-danger">
        <?= nl2br(Html::encode($message)); ?>
    </div>

    <p>
        Ha ocurrido un error durante la operación. Si usted creé que este error no debería haber sucedido, contáctese con nosotros explicando los pasos que había realizado. 
    </p>

</div>
