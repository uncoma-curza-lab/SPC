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
    public function actionNotify()
    {
        $now = date('m/d');
        $plusWeek = date("m/d", strtotime("+1 week", strtotime($now)));

        $limitDates = [
            getenv('DEADLINE_FIRST_FOUR_MONTH'),
            getenv('DEADLINE_LAST_FOUR_MONTH'),
        ];

        $inOneWeek = in_array($plusWeek, $limitDates);

        if (!$inOneWeek && !in_array($now, $limitDates)) {
            $this->stdout("Nothing for notify\n", Console::FG_GREEN);
            return;
        }

        $deadline = $now;
        if ($inOneWeek) {
            $deadline = $plusWeek;
        }

        $this->processEmail($deadline);

    }

    private function processEmail($date)
    {
        $emails = $this->getGroupEmails();
        $mailer = Yii::$app->mailer;
        $fromEmail = getenv("SMTP_USER");

        foreach ($emails as $group) {
            try {
                $message = $mailer->compose()
                    ->setFrom($fromEmail)
                    ->setTo($fromEmail)
                    ->setBcc($group)
                    ->setSubject('Recordatorio - Plazo de entrega programas de cátedra')
                    ->setHtmlBody(Yii::$app->view->render('@console/views/deadline_notify.php', ['deadline' => $date]));

                if ($message->send()) {
                    $this->stdout("Mail sended to " . implode(',', $group) . "\n", Console::FG_GREEN);
                } else {
                    $this->stdout("Error group to send: " . implode(',', $group) . "\n", Console::FG_RED);
                }
            } catch (\Throwable $e) {
                $this->stdout("Error group to send: " . implode(',', $group) . "\n", Console::FG_RED);
            }
        }
    }

    private function getGroupEmails()
    {
        $teacherRole = array_map(function($role) {
            return $role->id;
        }, Rol::find()->select('id')->where([
            'in',
            'rol_nombre',
            ['Profesor', 'Admin']
        ])->all());

        if (!$teacherRole) {
            throw new Exception('Role not exists');
        }

        $users = User::find()->where(['in', 'rol_id', $teacherRole])
                             ->with(['perfil'])
                             ->all();

        $emails = [];

        if (!$users) {
            return $emails;
        }

        foreach (array_chunk($users, 15) as $group) {
            $emails[] = array_column($group, 'email');
        }

        return $emails;
    }
}
