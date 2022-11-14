<?php

namespace frontend\controllers;

use common\domain\LessonType\commands\GetLessonTypes\GetLessonTypesCommand;
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


        if (Yii::$app->request->post()) {
            $postInfo = $model->loadData(Yii::$app->request->post());
            var_dump(Yii::$app->request->post());
            die;
            //$command = new NewTimeDistributionCommand(1);
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
            'lessonTypes' => $lessonTypes
        ]);
    }

}
