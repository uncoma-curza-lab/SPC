<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use froala\froalaeditor\FroalaEditorWidget;
$this->params['breadcrumbs'][] = ['label' => '...'];
$this->params['breadcrumbs'][] = ['label' => "Distribución Horaria", 'url' => ['dist-horaria', 'id' => $model->id]];
$this->params['breadcrumbs'][] = ['label' => "Cronograma tentativo", 'url' => ['crono-tentativo', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Activadades extracurriculares';
 ?>
 <?php $form = ActiveForm::begin([
   'enableAjaxValidation'      => true,
   'enableClientValidation'    => false,
   'validateOnChange'          => false,
   'validateOnSubmit'          => true,
   'validateOnBlur'            => false,
 ]); ?>

<h3>10. Planificación de actividades Extracurriculares</h3>
<?= FroalaEditorWidget::widget([
            'model' => $model,
            'attribute' => 'actv_extracur',
            'name' => 'actv_extracur',
            'options' => [
                'id'=>'actv_extracur'
            ],
            'clientOptions' => [
              'placeholderText' => 'Se prevé la participación de la cátedra en la organización de las Jornadas ..... Asimismo las actividades de extensión de cátedra',
              'height' => 100,
              'language' => 'es',
              'height' => 100,
              'theme' => 'gray',
              'toolbarButtons' => ['bold', 'italic', 'underline', '|', 'paragraphFormat', 'fontSize','color','|','undo','redo','align'],
            ],
]) ?>
<br>
<div class="form-group">
    <?= Html::submitButton('Terminar', ['class' => 'btn btn-success']) ?>
    <?= Html::a('Volver', ['crono-tentativo', 'id' => $model->id],['class' => 'btn btn-warning']) ?>
</div>
<?php ActiveForm::end(); ?>
