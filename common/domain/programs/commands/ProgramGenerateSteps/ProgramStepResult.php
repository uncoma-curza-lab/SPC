<?php

namespace common\domain\programs\commands\ProgramGenerateSteps;

use common\models\Programa;
use common\shared\commands\CommandAbstractResult;

class ProgramStepResult extends CommandAbstractResult
{
    protected $program; 

    function __construct(bool $success, string $message, array $data, Programa $program)
    {
        $this->program = $program;
        parent::__construct($success, $message, $data);
    }

    public function getProgram(): Programa
    {
        return $this->program;
    }
}
