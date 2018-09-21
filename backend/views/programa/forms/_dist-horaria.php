<?php
use froala\froalaeditor\FroalaEditorWidget;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
$this->params['breadcrumbs'][] = ['label' => '...'];
$this->params['breadcrumbs'][] = ['label' => "Evaluacion y acreditación", 'url' => ['eval-acred', 'id' => $model->id]];
$this->params['breadcrumbs'][] = ['label' => "Parciales, recuperatorios y coloquios", 'url' => ['parc-rec-promo', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Distribución Horaria';
 ?>
 <?php $form = ActiveForm::begin([
   'enableAjaxValidation'      => true,
   'enableClientValidation'    => false,
   'validateOnChange'          => false,
   'validateOnSubmit'          => true,
   'validateOnBlur'            => false,

 ]); ?>

<h3>8. Distribución horaria</h3>

<?= FroalaEditorWidget::widget([
            'model' => $model,
            'attribute' => 'distr_horaria',
            'name' => 'distr_horaria',
            'options' => [
                'id'=>'distr_horaria'
            ],
            'clientOptions' => [
              'placeholderText' => 'Según horas semanales establecidas por plan de estudio.',
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
    <?= Html::a('Volver', ['parc-rec-promo', 'id' => $model->id],['class' => 'btn btn-warning']) ?>
</div>
<?php ActiveForm::end(); ?>
