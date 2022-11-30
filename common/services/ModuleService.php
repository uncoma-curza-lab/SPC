<?php

namespace common\services;

use common\domain\Modules\commands\SaveModule\SaveModuleCommand;
use common\models\Programa as Program;
use Exception;
use Yii;

class ModuleService
{
    /**
     * process array modules and save (or update if existe the type)
     * @param Program $program
     * @param array $modules
     * @return array resultant modules
     */
    function processAndSaveModules(Program $program, array $modules)
    {
        $transaction = Yii::$app->db->beginTransaction();
        try {
            $newModules = [];

            foreach($modules as $keyModule => $module) {
                $command = new SaveModuleCommand($program, $keyModule, $module);
                $response = $command->handle();
                $dataResult = $response->getData();
                if (!$response->getResult()) {
                    if (array_key_exists('exception', $dataResult)) {
                        throw $dataResult['exception'];
                    }
                    throw new Exception('Hubo un error al intentar crear el módulo'); // add translt
                }
                if (!$program->saveModuleData($dataResult['module'])){
                    throw new Exception('Hubo un error al intentar guardar el Programa'); // add translt
                }
                $newModules[] = $dataResult['module'];
            }
            $transaction->commit();
            return [
                'modules' => $newModules
            ];
        } catch(Exception $exception) {
            $transaction->rollBack();
            return [
                'modules' => null,
                'error' => $exception->getMessage(),
            ]; 

        }
    }
}
