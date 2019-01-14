
<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\tabs\TabsX;
use froala\froalaeditor\FroalaEditorWidget;
 use unclead\multipleinput\MultipleInput;

/* @var $this yii\web\View */
/* @var $model backend\models\Programa */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="programa-form">

    <h3>Programa</h3>
    <?= $this->render('forms/_fundamentacion', ['model' => $model]); ?>

</div>
