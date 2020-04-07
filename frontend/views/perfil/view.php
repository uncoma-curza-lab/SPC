<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use common\models\PermisosHelpers;

/**
 * @var yii\web\View $this
 * @var frontend\models\Perfil $model
 */
$this->title = "Perfil";

//$photoInfo = $model->PhotoInfo;
//$photo = Html::img($photoInfo['url'],['alt'=>$photoInfo['alt']]);
?>
<div class="perfil-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php

    if (PermisosHelpers::userDebeSerPropietario('perfil', $model->id)) {
        echo Html::a('Update', ['update', 'id' => $model->id],
        ['class' => 'btn btn-primary']);
    } 
    ?>

    <div class="col-xs-6">
            <?=
                Html::a('Cambiar Contraseña', ['site/change-password'],
                    ['class' => 'btn btn-primary']);
            ?>
            <?php
                echo Html::a('Cambiar Email', ['site/change-email'],
                    ['class' => 'btn btn-info']);
            ?>
    </div>
        

    <div class="col-xs-6">
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            //'id',
            [
              'attribute' => 'user.username',
              'label' => 'Usuario'
            ],
            'nombre',
            'apellido',
            [
                'attribute' => 'user.email',
                'label' => 'Email',
                'value' => function($model){
                    $user = $model->getUser()->one();
                    $status = null;
                    if ($user) {
                        $status = $user->getEstado()->one();
                    }
                    if($status->estado_nombre == 'Activo'){
                        return $user->email;
                    } else { 
                        return "Sin verificar";
                    }
                    
                }

            ],
        //    'fecha_nacimiento',
        //    'genero.genero_nombre',
            //'localidad',
        //    'telefono',
            //'cargo',
            //'user_id',
        ],
    ]) ?>
    </div>
</div>
</div>
