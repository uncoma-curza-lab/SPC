<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\tabs\TabsX;
use froala\froalaeditor\FroalaEditorWidget;
/* @var $this yii\web\View */
/* @var $model backend\models\Programa */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="programa-form">

    <?php $form = ActiveForm::begin(); ?>

        <div class="form-group">
            <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
        </div>
    <h3>Portada</h3>
    <?= $this->renderAjax('_portada',['model'=>$model]); ?>
    <!--
     <?=
      TabsX::widget([
      'position' => TabsX::POS_ABOVE,
      'align' => TabsX::ALIGN_LEFT,
      //'height' => TabsX::SIZE_MEDIUM,
      //'bordered' => true,
      'encodeLabels' => false,
      'items' => [
          [
              'label' => 'Portada',
              'content' => $this->renderAjax('_portada',['model'=>$model]),
              'active' => true
          ],
          [
              'label' => '1. Fundamentación',
              //'content' => $form->field($model, 'fundament')->textArea(['maxlength' => true, 'style'=>'height:100px']),
              'content' => FroalaEditorWidget::widget([
                'model' => $model,
                'attribute' => 'fundament',
                'name' => 'fundament',
                'options' => [
                    'id'=>'fundament'
                ],
                'clientOptions' => [
                    'toolbarInline'=> false,
                    'theme' =>'gray',
                    'language'=>'es'
                ]
              ]),
              'headerOptions' => ['style'=>'font-size:15px'],
          ],
          [
              'label' => '2. Objetivo Plan de estudio',
              'headerOptions' => ['style'=>'font-size:15px'],
              'items' => [
                  [
                    'label' => 'Descripción',
                    'content' => $form->field($model, 'objetivo_plan')->textArea(['maxlength' => true]),
                  ],
                  [
                    'label' => 'Objetivos del programa',
                    'content' => "Agregar más items"
                  ]
              ]
          ],
          [
              'label' => '3. Contenido según Plan de Estudio',
              'content' => $form->field($model, 'contenido_plan')->textArea(['maxlength' => true]),
          ],
          [
              'label' => '4. Contenidos analíticos',
              'headerOptions' => ['style'=>'font-size:15px'],
              'items' => [
                  [
                    'label' => 'Unidad I',
                    'content' => "Cantidad de unidades",
                  ],
                  [
                    'label' => 'Unidad II',
                    'content' => "Cantidad de unidades"
                  ]
              ]
          ],
          [
              'label' => '5. Contenidos analíticos',
              'headerOptions' => ['style'=>'font-size:15px'],
              'items' => [
                  [
                    'label' => 'Bibliografía básica',
                    'content' => $this->renderAjax('_biblioBasicas', ['model'=>$model])
                  ],
                  [
                      'label' => 'Bibliografía de consulta',
                      'content' => $this->renderAjax('_biblioConsultas', ['model'=>$model])
                  ]
              ]
          ],
          [
              'label' => '6. Propuesta Metodológica',
              'content' => $form->field($model, 'propuesta_met')->textArea(['maxlength' => true]),
              'headerOptions' => ['style'=>'font-size:15px'],
          ],
          [
              'label' => '7. Evaluación y condiciones de acreditación',
              'content' => $form->field($model, 'evycond_acreditacion')->textArea(['maxlength' => true]),
              'headerOptions' => ['style'=>'font-size:15px'],
          ],
          [
              'label' => '8. Parciales, Recuperatorios y coloquios',
              'content' => $form->field($model, 'parcial_rec_promo')->textArea(['maxlength' => true]),
              'headerOptions' => ['style'=>'font-size:15px'],
          ],
          [
              'label' => '9. Distribución horaria',
              'content' => $form->field($model, 'distr_horaria')->textArea(['maxlength' => true]),
              'headerOptions' => ['style'=>'font-size:15px'],
          ],
          [
              'label' => '10. Cronograma Tentativo',
              'items' => [
                [
                  'label' => 'Calendario',
                  'content' => 'calendario'
                ],
              ],
              'headerOptions' => ['style'=>'font-size:15px'],
          ],
          [
              'label' => '11. Distribución horaria',
              'content' => $form->field($model, 'actv_extracur')->textInput(['maxlength' => true]),
              'headerOptions' => ['style'=>'font-size:15px'],
          ],
      ],
  ]);?>


-->

    <?php ActiveForm::end(); ?>

</div>
