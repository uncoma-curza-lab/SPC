<?php

namespace common\shared\commands;

interface CommandExecutionResult {
  public function getData() : mixed; 
  public function getResult() : bool;
  public function getMessage() : string;
}

