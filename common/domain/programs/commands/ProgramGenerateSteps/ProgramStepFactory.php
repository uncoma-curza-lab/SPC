<?php

namespace common\domain\programs\commands\ProgramGenerateSteps;

use common\domain\programs\commands\ProgramGenerateSteps\steps\BibliographyStep;
use common\domain\programs\commands\ProgramGenerateSteps\steps\CreateStep as CreateStep;
use common\domain\programs\commands\ProgramGenerateSteps\steps\FundamentalsStep;
use common\domain\programs\commands\ProgramGenerateSteps\steps\GenericStep;
use common\domain\programs\commands\ProgramGenerateSteps\steps\SaveStep;
use common\domain\programs\commands\ProgramGenerateSteps\steps\SignStep;
use common\domain\programs\commands\ProgramGenerateSteps\steps\TimeDistributionStep;
use common\domain\programs\commands\ProgramGenerateSteps\steps\TimelineStep;
use common\models\Programa;
use Exception;

class ProgramStepFactory
{
    /**
     * send step and instance(for update)
     * define flow and validations
     */
    static function getStep(string $type, Programa $program = null, array $data = null): StepInterface
    {
        if (!in_array($type, Programa::STEPS)) {
            throw new Exception('Step not exists');
        }

        return static::selectStep($type, $program, $data);
    }

    private static function selectStep(string $type, Programa $program = null, $data = null): StepInterface
    {
        if (!$program) {
            $type = Programa::CREATE_PROGRAM_STEP;
        }

        switch($type) {
            case Programa::CREATE_PROGRAM_STEP:
                return new CreateStep();
            case Programa::FUNDAMENTALS_STEP:
                return new GenericStep($program, 'fundamentacion');
            case Programa::PLAN_OBJECTIVE_STEP:
                return new GenericStep($program, 'obj-plan');
            case Programa::PROGRAM_OBJECTIVE_STEP:
                return new GenericStep($program, 'objetivo-programa');
            case Programa::PLAN_CONTENT_STEP:
                return new GenericStep($program, 'cont-plan');
            case Programa::ANALYTICAL_CONTENT_STEP:
                return new GenericStep($program, 'contenido_analitico');
            case Programa::BIBLIOGRAPHY_STEP:
                return new BibliographyStep($program);
            case Programa::METHOD_PROPOSAL_STEP:
                return new GenericStep($program, 'prop-met');
            case Programa::EVALUATION_AND_ACCREDITATION_STEP:
                return new GenericStep($program, 'eval-acred');
            case Programa::EXAMS_AND_PROMOTION_STEP:
                return new GenericStep($program, 'parc-rec-promo');
            case Programa::TIME_DISTRIBUTION_STEP:
                return new TimeDistributionStep($program);
            case Programa::TIMELINE_STEP:
                return new TimelineStep($program);
            case Programa::ACTIVITIES_STEP:
                return new GenericStep($program, 'actv-extra');
            case Programa::SIGN_STEP:
                return new SignStep($program);

            default:
                throw new Exception('Error, step not implemented');

        }
    }
}
