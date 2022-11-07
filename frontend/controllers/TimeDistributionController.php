<?php

namespace frontend\controllers;

use common\domain\LessonType\commands\GetLessonTypes\GetLessonTypesCommand;
use common\domain\programs\commands\ProgramGenerateSteps\ProgramStepFactory;
use common\domain\TimeDistribution\commands\CreateNewTimeDistribution\NewTimeDistributionCommand;
use common\domain\TimeDistribution\Entities\TimeDistribution;
use common\models\Module;
use common\models\Programa;
use frontend\models\TimeDistributionCreationForm;
use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;

/**
 * @Deprecated not used
 * CarreraController implements the CRUD actions for Carrera model.
 */
class TimeDistributionController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    public function actionCreate()
    {
        $lessonTypesCommand = new GetLessonTypesCommand();
        $lessonTypesResult = $lessonTypesCommand->handle();
        if (!$lessonTypesResult->getResult()) {
            return $this->goBack();
        }

        $lessonTypes = $lessonTypesResult->getData()['data'];

        $model = new TimeDistributionCreationForm();
        //$model = new TimeDistribution();
        $model->program = Programa::initNewProgram();
        //$model->module = new Module();
        //$model->module->program = $model->program;


        $programModel = $this->previousCreate();

        if (Yii::$app->request->post()) {
            $command = new NewTimeDistributionCommand(1);
            return $this->redirect(['view', 'id' => $model->id]);
        }
        //if ($model->load(Yii::$app->request->post()) && $model->save()) {
        //    return $this->redirect(['view', 'id' => $model->id]);
        //}

        return $this->render('create', [
            'model' => $model,
            'lessonTypes' => $lessonTypes
        ]);
    }

    private function previousCreate()
    {
        $command = ProgramStepFactory::getStep(Programa::CREATE_PROGRAM_STEP);
        $result = $command->handle();

        return $result->getProgram();
    }

}
