<?php
use kartik\tabs\TabsX;
use froala\froalaeditor\FroalaEditorWidget;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>
<?php $form = ActiveForm::begin([
'enableAjaxValidation'      => true,
'enableClientValidation'    => false,
'validateOnChange'          => false,
'validateOnSubmit'          => true,
'validateOnBlur'            => false,
]); ?>
<h3>2. Objetivo según Plan de estudio</h3>
<?= TabsX::widget([
  'position' => TabsX::POS_LEFT,
  'align' => TabsX::ALIGN_LEFT,
  'encodeLabels' => false,
  'items' => [
    [
      'label' => 'Descripcion',
      'content' =>  FroalaEditorWidget::widget([
                  'model' => $model,
                  'attribute' => 'objetivo_plan',
                  'name' => 'objetivo_plan',
                  'options' => [
                      'id'=>'objetivo_plan'
                  ]
      ])
    ],
    [
      'label' => 'Puntos',
      'content' =>  $this->renderAjax('_gridObjetivos', ['model'=>$model])
    ]
  ]
])?>

<div class="form-group">
    <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
</div>
<?php ActiveForm::end(); ?>
