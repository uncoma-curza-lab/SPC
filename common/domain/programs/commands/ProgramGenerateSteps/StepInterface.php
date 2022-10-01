<?php

namespace common\domain\programs\commands\ProgramGenerateSteps;
use common\shared\commands\CommandInterface;

abstract class StepInterface implements CommandInterface
{
    abstract function handle(): ProgramStepResult;
}

