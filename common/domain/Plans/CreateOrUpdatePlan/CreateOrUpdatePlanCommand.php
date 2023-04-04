<?php

namespace common\domain\Plans\CreateOrUpdatePlan;

use common\models\Plan;
use common\shared\commands\CommandInterface;
use Exception;

class CreateOrUpdatePlanCommand implements CommandInterface
{
    private Plan $plan;

    public function __construct(Plan $plan)
    {
        $this->plan = $plan;
    }

    public function handle() : CreateOrUpdatePlanResult
    {
        try {
            if ($this->isAmendPlan()) {
                if ($this->plan->parent->hasChild()) {
                    throw new Exception('Parent has child');
                }
                $this->plan->root_plan_id = Plan::getRootPlan($this->plan->parent_id);
            }

            $result = $this->plan->save();

            return new CreateOrUpdatePlanResult($result, 'Save plan', [
                'plan' => $this->plan,
            ]);
        } catch (\Throwable $e) {
            return new CreateOrUpdatePlanResult(false, 'Error save plan', [
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
