<?php

namespace common\domain\notifications\commands\DeleteNotification;

use common\models\Notification;
use common\models\Programa as Program;
use common\shared\commands\CommandInterface;

class DeleteAllNotificationsByProgramProcess implements CommandInterface
{
    protected Program $program;

    public function __construct(Program $program)
    {
        $this->program = $program;
    }

    public function handle() : DeleteNotificationResult
    {
        try {
            Notification::deleteAll([
                'programa_id' => $this->program->id
            ]);

            return new DeleteNotificationResult(true, 'Fueron eliminadas con éxito', []);
        } catch (\Throwable $e) {
            return new DeleteNotificationResult(false, 'Hubo un error al eliminar alguna notification', ['exception' => $e]);
        }
    }
}
