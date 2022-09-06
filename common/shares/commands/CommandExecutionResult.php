<?php

namespace common\shares\commands;

interface CommandExecutionResult {
  public function getData() : mixed; 
  public function getResult() : bool;
}

