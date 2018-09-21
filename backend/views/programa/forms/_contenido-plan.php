<?php
use froala\froalaeditor\FroalaEditorWidget;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->params['breadcrumbs'][] = ['label' => '...'];
$this->params['breadcrumbs'][] = ['label' => "Fundamentacion", 'url' => ['fundamentacion', 'id' => $model->id]];
$this->params['breadcrumbs'][] = ['label' => "Obj. según el plan de estudio", 'url' => ['objetivo-plan', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Contenido según el plan de estudio';
 ?>
 <?php $form = ActiveForm::begin([
   'enableAjaxValidation'      => true,
   'enableClientValidation'    => false,
   'validateOnChange'          => false,
   'validateOnSubmit'          => true,
   'validateOnBlur'            => false,
 ]); ?>

<h3>3. Contenido según Plan de Estudio</h3>

<?= FroalaEditorWidget::widget([
            'model' => $model,
            'attribute' => 'contenido_plan',
            'name' => 'contenido_plan',
            'options' => [
                'id'=>'contenido_plan'
            ],
            'clientOptions' => [
              'placeholderText' => 'son los referidos al plan de estudios tal lo allí establecido.',
              'height' => 100,
              'language' => 'es',
              'height' => 100,
              'theme' => 'gray',
              'toolbarButtons' => ['bold', 'italic', 'underline', '|', 'paragraphFormat', 'fontSize','color','|','undo','redo','align'],
            ],
]) ?>
<br>
<div class="form-group">
    <?= Html::submitButton('Seguir', ['class' => 'btn btn-success']) ?>
    <?= Html::a('Volver', ['objetivo-plan', 'id' => $model->id],['class' => 'btn btn-warning']) ?>

</div>
<?php ActiveForm::end(); ?>
