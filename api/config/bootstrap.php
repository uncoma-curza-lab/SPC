<?php

use api\modules\v1\models\Asignatura as AsignaturaApi;
use api\modules\v1\models\Plan as PlanApi;
use api\modules\v1\models\Carrera as CarreraApi;
use api\modules\v1\models\Departamento as DepartamentoApi;
use api\modules\v1\models\Programa as ProgramaApi;
use common\models\Asignatura;
use common\models\Departamento;
use common\models\Carrera;
use common\models\Plan;
use common\models\Programa;

Yii::$container->setDefinitions([
    Asignatura::class => AsignaturaApi::class,
    Plan::class => PlanApi::class,
    Carrera::class => CarreraApi::class,
    Departamento::class => DepartamentoApi::class,
    Programa::class => ProgramaApi::class,
]);
