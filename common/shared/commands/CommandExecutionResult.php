<?php

namespace common\shared\commands;

interface CommandExecutionResult {
  public function getData() : array;
  public function getResult() : bool;
  public function getMessage() : string;
}

