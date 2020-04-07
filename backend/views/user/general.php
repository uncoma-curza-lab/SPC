<?php
 
use yii\helpers\Html;
use yii\widgets\DetailView;
use common\models\PermisosHelpers;
 
/* @var $this yii\web\View */
/* @var $model common\models\user */
 
$show_this_nav = PermisosHelpers::requerirMinimoRol('SuperUsuario');
 
$this->params['breadcrumbs'][] = ['label' => 'Acciones generales', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-view">
 
    <h1><?= Html::encode($this->title) ?></h1>
 
     <p>
 
<?php if (!Yii::$app->user->isGuest && $show_this_nav) {
      echo Html::a('Cambiar de estado todos los usuarios', ['set-state-users'], 
                             ['class' => 'btn btn-primary']);}?>
 
 
</div>
 
</div>
