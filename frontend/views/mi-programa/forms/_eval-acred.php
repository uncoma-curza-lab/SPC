<?php
use dosamigos\tinymce\TinyMce;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
$mensaje = [ 'onclick'=>"return confirm('No se guardarán los cambios de esta pestaña, ¿desea salir?')"];
$this->params['items'][] = ['label' => '1. Fundamentación','url' => Url::to(['cargar', 'id' => $model->id]), 'options'=>[ 'onclick'=>"return confirm('No se guardarán los cambios de esta pestaña, ¿desea salir?')"]];
$this->params['items'][] = ['label' => '2. Objetivos según plan de estudio', 'url' => Url::to(['objetivo-plan', 'id' => $model->id]), 'options'=> $mensaje];
$this->params['items'][] = ['label' => '2.1 Objetivos del programa', 'url' => Url::to(['objetivo-programa', 'id' => $model->id]), 'options'=> $mensaje];
$this->params['items'][] = ['label' => '3. Contenidos según plan de estudio', 'url' => Url::to(['contenido-plan', 'id' => $model->id]), 'options'=> $mensaje];
$this->params['items'][] = ['label' => '4. Contenidos analíticos', 'url' => Url::to(['contenido-analitico', 'id' => $model->id]), 'options'=> $mensaje];
$this->params['items'][] = ['label' => '5. Bibliografía', 'url' => Url::to(['bibliografia', 'id' => $model->id]), 'options'=> $mensaje];
$this->params['items'][] = ['label' => '6. Propuesta Metodológica', 'url' => Url::to(['propuesta-metodologica', 'id' => $model->id]), 'options'=> $mensaje];
$this->params['items'][] = ['label' => '7. Evaluación y cond. de acreditación'];
$this->params['items'][] = ['label' => '8. Parciales, recuperatorios y promociones', 'url' => Url::to(['parcial-rec-promo', 'id' => $model->id]), 'options'=> $mensaje];
$this->params['items'][] = ['label' => '9. Distribución horaria', 'url' => Url::to(['dist-horaria', 'id' => $model->id]), 'options'=> $mensaje];
$this->params['items'][] = ['label' => '10. Cronograma tentativo', 'url' => Url::to(['crono-tentativo', 'id' => $model->id]), 'options'=> $mensaje];
$this->params['items'][] = ['label' => '11. Actividad extracurricular', 'url' => Url::to(['actividad-extracurricular', 'id' => $model->id]), 'options'=> $mensaje];
$this->params['breadcrumbs'][] = ['label' => '...'];
$this->params['breadcrumbs'][] = ['label' => "Bibliografía", 'url' => ['bibliografia', 'id' => $model->id]];
$this->params['breadcrumbs'][] = ['label' => "Propuesta metodológica", 'url' => ['propuesta-metodologica', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Evaluación y condiciones de acreditación';
$porcentaje = $model->calcularPorcentajeCarga();
?>
<?php $form = ActiveForm::begin([
  'enableAjaxValidation'      => false,
  'enableClientValidation'    => false,
  'validateOnChange'          => true,
  'validateOnSubmit'          => false,
  'validateOnBlur'            => false,
]); ?>
<div class="row">
  <div class="col-md-2 text-right">
    <label>Programa completado: </label>
  </div>
  <div class="col-md-10 ">
    <div class="progress">
      <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="<?= $porcentaje ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?= $porcentaje ?>%">
         <?= $porcentaje ?>%
      </div>
    </div>
  </div>
</div>
<h3>7. Evaluación y condiciones de acreditación</h3>

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
        'toolbar' => "undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link | fullscreen ",
        'branding' => false,
        'protect' => [
            "/\<\/?(if|endif)\>/g",  // Protect <if> & </endif>
            "/\<xsl\:[^>]+\>/g",  // Protect <xsl:...>
            "/<\?php.*?\?>/g"  // Protect php code
        ],

    ]
])->label('') ?>
<br>
<div class="form-group">
  <div class="row">
    <div class="col-xs-6 text-left">
      <?= Html::a('Atrás', ['propuesta-metodologica', 'id' => $model->id],['onclick'=>"return confirm('No se guardarán los cambios de esta sección, ¿desea salir?')",'class' => 'btn btn-warning']) ?>
      <?= Html::submitButton('Guardar y salir',['class' => 'btn btn-info' , 'name'=>'submit','value' => 'salir']) ?>
    </div>
    <div class="col-xs-6 text-right">
      <?= Html::submitButton('Seguir', ['class' => 'btn btn-success']) ?>
    </div>
  </div>
</div>

<?php ActiveForm::end(); ?>
