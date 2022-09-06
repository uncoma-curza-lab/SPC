<?php

namespace common\shared\commands;

interface CommandInterface {
  public function handle() : CommandExecutionResult;
}

