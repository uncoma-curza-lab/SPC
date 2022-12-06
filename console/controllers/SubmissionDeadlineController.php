<?php

namespace console\controllers;

use common\models\Rol;
use common\models\User;
use Exception;
use Yii;
use yii\console\Controller;
use yii\helpers\Console;

class SubmissionDeadlineController extends Controller
{
    const DATES = [
        '03/01',
        '08/04'
    ];


    public function actionNotify()
    {
        $now = date('m/d');

        if (!in_array($now, self::DATES)) {
            $this->stdout("Nothing for notify\n", Console::FG_GREEN);
            return;
        }

        $this->processEmail();

    }

    private function processEmail()
    {
        $emails = $this->getGroupEmails();
        $mailer = Yii::$app->mailer;
        $fromEmail = getenv("SMTP_USER");

        foreach ($emails as $group) {
            $message = $mailer->compose()
                ->setFrom($fromEmail)
                ->setTo($fromEmail)
                ->setBcc($group)
                ->setSubject('Recordatorio - Plazo de entrega programas de cátedra')
                ->setHtmlBody(Yii::$app->view->render('@console/views/deadline_notify.php'));

            if ($message->send()) {
                $this->stdout("Mail sended to " . implode(',', $group) . "\n", Console::FG_GREEN);
            } else {
                $this->stdout("Error group to send: " . implode(',', $group) . "\n", Console::FG_RED);
            }
        }
    }

    private function getGroupEmails()
    {
        $teacherRole = Rol::find()->where(['=', 'rol_nombre', 'Profesor'])->one();
        if (!$teacherRole) {
            throw new Exception('Role not exists');
        }

        $users = User::find()->where(['=', 'rol_id', $teacherRole->id])
                             ->with(['perfil'])
                             ->all();

        foreach (array_chunk($users, 15) as $group) {
            $emails[] = array_column($group, 'email');
        }

        return $emails;
    }
}
