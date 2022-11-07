<?php

namespace common\domain\TimeDistribution\commands\CreateNewTimeDistribution;

use common\shared\commands\CommandInterface;

class NewTimeDistributionCommand implements CommandInterface
{
    protected $programId;

    public function __construct(int $programId, int $year, array $lessonTypes)
    {
        $this->programId = $programId;
    }

    public function handle() : NewTimeDistributionResult
    {
        try {
            return new NewTimeDistributionResult(true, 'Fueron eliminadas con éxito', []);
        } catch (\Throwable $e) {
            return new NewTimeDistributionResult(false, 'Hubo un error al eliminar alguna notification', ['exception' => $e]);
        }
    }
}
