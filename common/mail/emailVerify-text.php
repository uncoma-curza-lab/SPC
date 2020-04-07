<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $user common\models\User */

$verifyLink = Yii::$app->urlManager->createAbsoluteUrl(['site/verify-email', 'token' => $user->verification_email_token]);
?>
<p>Hola!</p>
    <p>Este mensaje fue generado automáticamente por el sistema de programas de cátedra del C.U.R.Z.A.</p>
    <p>
        Si usted solicitó la verificación del correo electrónico para el usuario 
        <b><?= Html::encode($user->username) ?> </b>, 
        entonces proceda a verificar el mismo haciendo click en el siguiente enlace:
    </p>

    <p><?= $verifyLink ?></p>

    <p> En caso contrario, si no espera este correo, ignórelo. </p>
    <p></p>
    <small>Laboratorio de Informática del C.U.R.Z.A.</small>
