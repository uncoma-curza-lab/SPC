<?php

namespace frontend\controllers;

use common\domain\LessonType\commands\GetLessonTypes\GetLessonTypesCommand;
use common\models\Module;
use common\models\Programa;
use common\models\TimeDistribution;
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

    public function beforeAction($action) {
        if(defined('YII_DEBUG') && YII_DEBUG){
            \Yii::$app->assetManager->forceCopy = true;
        }
        return parent::beforeAction($action);
    }
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
        $model->program = Programa::initNewProgram();

        $error = null;


        if (Yii::$app->request->post()) {
            $response = $model->createDistributionTime(Yii::$app->request->post());
            if ($response['result']) {
                return $this->redirect([
                    'view',
                    'id' => $response['module']->program->id
                ]);
            } else {
                $model->load(Yii::$app->request->post());
                $error = $response['message'];
                //error
            }
        }

        return $this->render('create', [
            'model' => $model,
            'lessonTypes' => $lessonTypes,
            'error' => $error
        ]);
    }

    public function actionView($id)
    {
        $module = Module::find()->where(['program_id' => $id])
                                ->andWhere(['type' => TimeDistribution::MODULE_NAME])
                                ->with(['timeDistributions'])->one();

        if (!$module) {
            Yii::$app->session->setFlash('warning',
             '<p>Lamentamos molestarlo, </p>
             <p>El programa no posee el modulo de distribución horaria.</p>');
            return $this->goBack();
        }

        $viewModule = $this->mapDistribution($module);

        return $this->render('view-module', ['model' => $viewModule]);
    }

    private function mapDistribution(Module $module)
    {
        $response = [];
        $loadTimeWeek = $module->program->asignatura->carga_horaria_sem;
        $totalLoadTime = $module->program->asignatura->carga_horaria_cuatr;
        foreach($module->timeDistributions as $distribution) {
            $response['time_distribution'][] = [
                'lesson_type' => $distribution->lessonType->description,
                'percentage' => $distribution->percentage_quantity,
                'relative_hours' => round($loadTimeWeek * $distribution->percentage_quantity / 100, 2)
            ];
        }

        $response['week_load_time'] = $loadTimeWeek;
        $response['total_load_time'] = $totalLoadTime;;

        return $response;
    }

}
