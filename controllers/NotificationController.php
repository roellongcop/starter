<?php

namespace app\controllers;

use Yii;
use app\helpers\App;
use app\models\Notification;
use app\models\search\NotificationSearch;
use yii\helpers\Inflector;

/**
 * NotificationController implements the CRUD actions for Notification model.
 */
class NotificationController extends Controller 
{
    public function actionFindByKeywords($keywords='')
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
        $model = new Notification();
        $post = App::post();

        if (isset($post['process-selected'])) {
            $process = Inflector::humanize($post['process-selected']);
            if (isset($post['selection'])) {

                $models = Notification::all($post['selection']);

                if (isset($post['confirm_button'])) {
                    switch ($post['process-selected']) {
                        case 'read':
                            Notification::readAll(['id' => $post['selection']]);
                            break;
                        case 'unread':
                            Notification::unreadAll(['id' => $post['selection']]);
                            break;
                        case 'active':
                            Notification::activeAll(['id' => $post['selection']]);
                            break;
                        case 'in_active':
                            Notification::inactiveAll(['id' => $post['selection']]);
                            break;
                        case 'delete':
                            Notification::deleteAll(['id' => $post['selection']]);
                            break;
                        default:
                            # code...
                            break;
                    }
                    App::success("Data set to '{$process}'");  
                }
                else {
                    return $this->render('bulk-action', [
                        'model' => $model,
                        'models' => $models,
                        'process' => $process,
                        'post' => $post
                    ]);
                }
            }
            else {
                App::warning('No Checkbox Selected');
            }
        }
        else {
            App::warning('No Process Selected');
        }

        return $this->redirect($model->indexUrl);
    }

    public function actionPrint()
    {
        return $this->exportPrint(new NotificationSearch());
    }

    public function actionExportPdf()
    {
        return $this->exportPdf(new NotificationSearch());
    }

    public function actionExportCsv()
    {
        return $this->exportCsv(new NotificationSearch());
    }

    public function actionExportXls()
    {
        return $this->exportXls(new NotificationSearch());
    }

    public function actionExportXlsx()
    {
        return $this->exportXlsx(new NotificationSearch());
    }

    public function actionInActiveData()
    {
        # dont delete; use in condition if user has access to in-active data
    }
}