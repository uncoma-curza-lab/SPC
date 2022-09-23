<?php

namespace common\domain\programs\commands\ApproveProgram;

use common\shared\commands\CommandExecutionResult;

class CommandApproveResult implements CommandExecutionResult
{
  protected bool $success;
  protected string $message;
  protected array $data;

  function __construct(bool $success, string $message, array $data)
  {
    $this->success = $success;
    $this->message = $message;
    $this->data = $data;

  }

  public function getData() : array
  {
    return $this->data;
  }

  public function getResult() : bool
  {
    return $this->success;
  }

  public function getMessage() : string
  {
    return $this->message;
  }
}
