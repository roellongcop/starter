<?php

namespace app\controllers;

use app\helpers\App;
use app\models\Notification;
use app\models\search\NotificationSearch;

/**
 * NotificationController implements the CRUD actions for Notification model.
 */
class NotificationController extends Controller
{
    public function actionFindByKeywords($keywords = '')
    {
        return $this->asJson(
            Notification::findByKeywords($keywords, ['message'])
        );
    }

    /**
     * Lists all Notification models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new NotificationSearch();
        $dataProvider = $searchModel->search(['NotificationSearch' => App::queryParams()]);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Notification model.
     * @param integer $token
     * @return mixed
     * @throws ForbiddenHttpException if the model cannot be found
     */
    public function actionView($token)
    {
        $model = Notification::controllerFind($token, 'token');
        $model->setToRead();
        $model->save();

        return $this->redirect($model->link);
    }

    /**
     * Deletes an existing Notification model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $token
     * @return mixed
     * @throws ForbiddenHttpException if the model cannot be found
     */
    public function actionDelete($token)
    {
        $model = Notification::controllerFind($token, 'token');

        if ($model->delete()) {
            App::success('Successfully Deleted');
        } 
        else {
            App::danger(json_encode($model->errors));
        }

        return $this->redirect($model->indexUrl);
    }
}