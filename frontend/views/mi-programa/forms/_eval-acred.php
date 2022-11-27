<?php

use common\models\Programa;
use dosamigos\tinymce\TinyMce;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$js = "$(document).ready(function(){
  $('[data-toggle=\"popover\"]').popover();
});
$(function () {
  $('[data-toggle=\"tooltip\"]').tooltip()
})";
$this->registerJs($js);
?>
<?php $form = ActiveForm::begin([
  'enableAjaxValidation'      => false,
  'enableClientValidation'    => false,
  'validateOnChange'          => true,
  'validateOnSubmit'          => false,
  'validateOnBlur'            => false,
]); ?>
<?= $this->render('_menu_steps', [
  'model' => $model,
  'currentView' => Programa::EVALUATION_AND_ACCREDITATION_STEP
]) ?>
<h3>Evaluación y condiciones de acreditación<span  style="font-size:15px"><a href="#" data-toggle="popover" title="Evaluación y condiciones de acreditación"
    data-content="Señalar alternativas de cursado regular, promocional, y libre y criterios de evaluación y acreditación de forma discriminada.">
    <span class="glyphicon glyphicon-question-sign"></span> Ayuda</a></span></h3>

<?= $form->field($model, 'evycond_acreditacion')->widget(TinyMce::className(), [
    'options' => ['rows' => 16 ],
    'language' => 'es',
    'clientOptions' => [
        'placeholder' => 'qasdasdasdwe',

        'plugins' => [
            "advlist autolink lists link charmap
            "//print
            ."preview anchor",
            "searchreplace visualblocks code fullscreen",
            "insertdatetime  table contextmenu paste"
        ],
        'toolbar' => "table | undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link | fullscreen ",
        'contextmenu' => "copy  paste | link",
        'branding' => false,
        'protect' => [
            "/\<\/?(if|endif)\>/g",  // Protect <if> & </endif>
            "/\<xsl\:[^>]+\>/g",  // Protect <xsl:...>
            "/<\?php.*?\?>/g"  // Protect php code
        ],

    ]
])->label('') ?>
<br>

<div class="row">
  <div class="col-xs-6 text-left">
    <?= Html::a('Salir sin guardar', ['index'],['onclick'=>"return confirm('No se guardarán los cambios de esta sección, ¿desea salir?')",'class' => 'btn btn-danger']); ?>
    <?= Html::submitButton('Guardar y salir',['class' => 'btn btn-info' , 'name'=>'submit','value' => 'salir']) ?>
  </div>
  <div class="col-xs-6 text-right">
    <?= Html::a('Atrás', ['propuesta-metodologica', 'id' => $model->id],['onclick'=>"return confirm('No se guardarán los cambios de esta sección, ¿desea salir?')",'class' => 'btn btn-warning']) ?>
    <?= Html::submitButton('Siguiente', ['class' => 'btn btn-success']); ?>
  </div>
</div>

<?php ActiveForm::end(); ?>
