<?php

namespace common\domain\Modules\commands\SaveModule;

use common\domain\Modules\commands\SaveModule\SaveModuleResult;
use common\domain\TimeDistribution\commands\CreateNewTimeDistribution\NewTimeDistributionCommand;
use common\models\Module;
use common\models\Programa;
use common\shared\commands\CommandInterface;
use Exception;
use Yii;

class SaveModuleCommand implements CommandInterface
{
    protected Programa $program;
    protected string $type;
    protected array $data;

    public function __construct(Programa $program, string $type, array $data)
    {
        $this->program = $program;
        $this->data = $data;
        $this->type = $type;
    }

    public function handle() : SaveModuleResult 
    {
        $transaction = Yii::$app->db->beginTransaction();
        try {

            $commandGenerateModuleClass = null;
            switch($this->type) {
                case Module::TIME_DISTRIBUTION_TYPE:
                    if ($this->program->getYear() >= 2023) {
                        $commandGenerateModuleClass = NewTimeDistributionCommand::class;
                    }
                    break;
            }
            $module = $this->getModule($this->program->id, $this->type);
            if ($module) {
                $module->clearModule();
            } else {
                $module = new Module();
            }

            $module->program_id = $this->program->id;
            if ($this->data['value']) {
                $module->value = $this->data['value'];
            } else if ($module->type === Module::TIME_DISTRIBUTION_TYPE){
                $module->value = '--';
            }
            $module->type = $this->type;

            if (!$module->save()) {
                throw new Exception('Module validation error');
            }

            if ($commandGenerateModuleClass) {
                $executeCommand = new $commandGenerateModuleClass($module, $this->data);
                $response = $executeCommand->handle();
                if (!$response->getResult()) {
                    $data = $response->getData();
                    if (array_key_exists('exception', $data)) {
                        throw $data['exception'];
                    }
                    throw new Exception('error create module');
                }
            }

            $transaction->commit();
            return new SaveModuleResult(true, 'Nuevo módulo creado con éxito', ['module' => $module]);
        } catch (\Throwable $e) {
            $transaction->rollBack();
            return new SaveModuleResult(false, 'Hubo un error al crear el módulo', ['exception' => $e]);
        }
    }

    public function getModule($programId, $type)
    {
        return Module::find()->where(['=', 'program_id', $programId])
                             ->andWhere(['=', 'type', $type])
                             ->one();

    }
}
