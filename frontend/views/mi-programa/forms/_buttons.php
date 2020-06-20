<?php use yii\helpers\Html; ?> 
<div class="row">
  <div class="col-xs-6 text-left">
    <?= Html::a('Salir sin guardar', ['index'],['onclick'=>"return confirm('No se guardarán los cambios de esta sección, ¿desea salir?')",'class' => 'btn btn-danger']); ?>
    <?= Html::submitButton('Guardar y salir',['class' => 'btn btn-info' , 'name'=>'submit','value' => 'salir']) ?>
  </div>
  <div class="col-xs-6 text-right">
    <?= Html::a('Atrás', ['dist-horaria', 'id' => $model->id],['onclick'=>"return confirm('No se guardarán los cambios de esta sección, ¿desea salir?')",'class' => 'btn btn-warning']) ?>
    <?= Html::submitButton('Siguiente', ['class' => 'btn btn-success']); ?>
  </div>
</div>
