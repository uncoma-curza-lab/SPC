<?php

namespace api\modules\v1\controllers;

use Yii;
use api\modules\v1\models\Programa;
use api\modules\v1\models\search\PlanSearch;
use yii\rest\ActiveController;
use yii\web\NotFoundHttpException;
use yii\data\ActiveDataProvider;
use common\models\Status;
use Mpdf;
use yii\helpers\Url;
use yii\web\Link;

/**
 * PlanController implements the CRUD actions for Plan model.
 */
class BibliotecaController extends ActiveController
{
    public $modelClass = 'api\modules\v1\models\Programa';

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        //Formato
        $behaviors['contentNegotiator'] = [
            'class' => \yii\filters\ContentNegotiator::className(),
            'formats' => [
                'application/json' => \yii\web\Response::FORMAT_JSON,
            ],
        ];
        $behaviors['corsFilter'] = [

            'class' => \yii\filters\Cors::className(),
            'cors' => [
                'Origin' => ['*'],
                // Permitir solo get
                'Access-Control-Request-Method' => ['GET'],
                'Access-Control-Request-Headers' => ['*'],
                'Access-Control-Allow-Origin' => ['*'],
                'Access-Control-Allow-Credentials' => false,
                'Access-Control-Max-Age' => 3600,
                'Access-Control-Expose-Headers' => [],
            ],
        ];
        //verbo y accion
        $behaviors['verbs'] = [
            'class' => \yii\filters\VerbFilter::className(),
            'actions' => [
                //'create' => ['POST'],
                //'update' => ['PUT','PATCH','POST'],
                //'delete' => ['GET'],
                'index' => ['GET'],
                'carreras' => ['GET']
            ]
        ];
        return $behaviors;
    }

    public function actions()
    {
        $actions = parent::actions();
        unset($actions['index']);
        return $actions;
    }

    public function actionIndex()
    {
        $biblioteca = Status::find()->where(['=', 'descripcion', 'Biblioteca'])->one();
        if ($biblioteca) {
            $bibliotecaId = $biblioteca->id;
        }
        $query = Programa::find()->andFilterWhere(['=', 'status_id', $bibliotecaId]);

        if (array_key_exists('asignatura', $_GET))
            $query->andFilterWhere(['=', 'asignatura_id', $_GET['asignatura']]);


        $activeData = new ActiveDataProvider([
            //'query' => Plan::find()->andFilterWhere(['=','id',$_GET['dpto']]),
            'query' => $query,
            'pagination' => false,
        ]);
        return $activeData;
    }
    public function actionGetId($id)
    {
        $model = $this->findModel($id);

        $activeData = new ActiveDataProvider([
            //'query' => Plan::find()->andFilterWhere(['=','id',$_GET['dpto']]),
            'query' => $model, 
            'pagination' => false,
        ]);

        return $model;
    }

    /*
    * Comienzan las funciones para crear y exportar un PDF
    */
    public function actionExportPdf($id)
    {
        $model = $this->findModel($id);
        $response = [];
        if (!file_exists('public/programas/' . $id . '.pdf')) {
            $mpdf = new Mpdf\Mpdf(['utf-8', 'A4', 'tempDir' => __DIR__ . '/tmp']);
            $stylesheet = file_get_contents('../../frontend/web/css/estilo-pdf.css');
            //$header = 'Document header';
            //$html   = 'Your document content goes here';

            //$mpdf = new Mpdf('utf-8', 'A4', 0, '', 12, 12, 25, 15, 12, 12);
            //$mpdf->SetHTMLHeader($header);
            $mpdf->WriteHTML($stylesheet, \Mpdf\HTMLParserMode::HEADER_CSS);
            $mpdf->WriteHTML($this->renderPartial('portada', ['model' => $model]));
            $mpdf->addPage();
            $footer =  '<span style="font-size:12px; !important"> Página {PAGENO} de {nb}</span>';
            $mpdf->SetHTMLFooter($footer);

            $mpdf->WriteHTML($this->renderPartial('paginas', ['model' => $model]));
            $mpdf->Output('public/programas/' . $model->id . ".pdf", 'f');
        }
        $response = [
            'file' => Url::to(['/public/programas/' . $id . '.pdf'], true),
            'status' => true
        ];
        return $response;
    }

    public function actionDownloadPdf($id)
    {
        $model = $this->findModel($id);
        $response = [];
        if (!file_exists('public/programas/' . $id . '.pdf')) {
            $mpdf = new Mpdf\Mpdf(['utf-8', 'A4', 'tempDir' => __DIR__ . '/tmp']);
            $stylesheet = file_get_contents('../../frontend/web/css/estilo-pdf.css');
            //$header = 'Document header';
            //$html   = 'Your document content goes here';

            //$mpdf = new Mpdf('utf-8', 'A4', 0, '', 12, 12, 25, 15, 12, 12);
            //$mpdf->SetHTMLHeader($header);
            $mpdf->WriteHTML($stylesheet, \Mpdf\HTMLParserMode::HEADER_CSS);
            $mpdf->WriteHTML($this->renderPartial('portada', ['model' => $model]));
            $mpdf->addPage();
            $footer =  '<span style="font-size:12px; !important"> Página {PAGENO} de {nb}</span>';
            $mpdf->SetHTMLFooter($footer);

            $mpdf->WriteHTML($this->renderPartial('paginas', ['model' => $model]));
            $mpdf->Output('public/programas/' . $model->id . ".pdf", 'f');
        }
        //$response = [
            //'file' => Url::to(['/public/programas/' . $id . '.pdf'], true),
            //'status' => true
        //];
        return \Yii::$app->response->sendFile('public/programas/' . $model->id . ".pdf");
    }

    /**
     * Finds the Programa model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Programa the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (is_numeric($id)) {
            $biblioteca = Status::find()->where(['=', 'descripcion', 'Biblioteca'])->one();
            if (!$biblioteca) {
                throw new NotFoundHttpException('Hubo un problema al buscar el programa.');
            }

            $bibliotecaId = $biblioteca->id;
            $model = Programa::find()->where('id = :id', [':id' => $id])
                                     ->andFilterWhere(['=','status_id',$bibliotecaId])
                                     ->one();
            if ($model) {
                return $model;
            }
        }
        throw new NotFoundHttpException('No se pudo encontrar lo que buscaba');
    }
}
