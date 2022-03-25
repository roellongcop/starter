<?php

namespace app\controllers;

use Yii;
use app\helpers\App;
use app\models\User;
use app\models\VisitLog;
use app\models\search\VisitLogSearch;
use yii\helpers\ArrayHelper;

/**
 * VisitLogController implements the CRUD actions for VisitLog model.
 */
class VisitLogController extends Controller
{
    public function actionFindByKeywords($keywords='')
    { 
        return $this->asJson(VisitLog::findByKeywords($keywords, ['v.ip', 'u.username']));
    }

    /**
     * Lists all VisitLog models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new VisitLogSearch();
        $dataProvider = $searchModel->search(['VisitLogSearch' => App::queryParams()]);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single VisitLog model.
     * @param integer $id
     * @return mixed
     * @throws ForbiddenHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => VisitLog::controllerFind($id),
        ]);
    }

    /**
     * Deletes an existing VisitLog model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws ForbiddenHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = VisitLog::controllerFind($id);

        if($model->delete()) {
            App::success('Successfully Deleted');
        }
        else {
            App::danger(json_encode($model->errors));
        }

        return $this->redirect($model->indexUrl);
    }

    public function actionChangeRecordStatus()
    {
        return $this->changeRecordStatus();
    }

    public function actionBulkAction()
    {
        return $this->bulkAction();
    }

    public function actionPrint()
    {
        return $this->exportPrint();
    }

    public function actionExportPdf()
    {
        return $this->exportPdf();
    }

    public function actionExportCsv()
    {
        return $this->exportCsv();
    }

    public function actionExportXls()
    {
        return $this->exportXls();
    }

    public function actionExportXlsx()
    {
        return $this->exportXlsx();
    }

    public function actionInActiveData()
    {
        # dont delete; use in condition if user has access to in-active data
    }
}