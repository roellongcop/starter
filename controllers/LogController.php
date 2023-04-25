<?php

namespace app\controllers;

use app\helpers\App;
use app\models\Log;
use app\models\search\LogSearch;

/**
 * LogController implements the CRUD actions for Log model.
 */
class LogController extends Controller
{
    public function actionFindByKeywords($keywords = '')
    {
        return $this->asJson(
            Log::findByKeywords($keywords, [
                'method',
                'action',
                'controller',
                'table_name',
                'model_name',
            ])
        );
    }

    /**
     * Lists all Log models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new LogSearch();
        $dataProvider = $searchModel->search(['LogSearch' => App::queryParams()]);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Log model.
     * @param integer $id
     * @return mixed
     * @throws ForbiddenHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => Log::controllerFind($id),
        ]);
    }

    /**
     * Deletes an existing Log model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws ForbiddenHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = Log::controllerFind($id);

        if ($model->delete()) {
            App::success('Successfully Deleted');
        } else {
            App::danger(json_encode($model->errors));
        }

        return $this->redirect($model->indexUrl);
    }
}