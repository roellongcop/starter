<?php

namespace app\controllers;

use app\helpers\App;
use app\models\Queue;
use app\models\search\QueueSearch;

/**
 * QueueController implements the CRUD actions for Queue model.
 */
class QueueController extends Controller
{
    public function actionFindByKeywords($keywords = '')
    {
        return $this->asJson(
            Queue::findByKeywords($keywords, ['channel', 'job', 'pushed_at'])
        );
    }

    /**
     * Lists all Queue models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new QueueSearch();
        $dataProvider = $searchModel->search(['QueueSearch' => App::queryParams()]);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Queue model.
     * @param integer $id
     * @return mixed
     * @throws ForbiddenHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => Queue::controllerFind($id),
        ]);
    }

    /**
     * Deletes an existing Queue model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws ForbiddenHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = Queue::controllerFind($id);

        if ($model->delete()) {
            App::success('Successfully Deleted');
        } else {
            App::danger(json_encode($model->errors));
        }

        return $this->redirect($model->indexUrl);
    }
}