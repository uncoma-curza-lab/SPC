<?php

namespace common\domain\Plans\CreateNewPlan;

use common\models\Plan;
use common\shared\commands\CommandInterface;

class CreateNewPlanCommand implements CommandInterface
{
    private Plan $plan;

    public function __construct(Plan $plan)
    {
        $this->plan = $plan;
    }

    public function handle() : CreateNewPlanResult
    {
        try {
            if ($this->isAmendPlan()) {
                $this->plan->root_plan_id = Plan::getRootPlan($this->plan->parent_id);
            }

            $result = $this->plan->save();

            return new CreateNewPlanResult($result, 'Save plan', [
                'plan' => $this->plan,
            ]);
        } catch (\Throwable $e) {
            return new CreateNewPlanResult(false, 'Error save plan', [
                'exception' => $e,
                'message' => $e->getMessage(),
                'plan' => $this->plan,
            ]);
        }
    }

    private function isAmendPlan(): bool
    {
        return boolval($this->plan->parent_id);

    }
}
