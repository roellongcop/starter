<?php

namespace app\controllers;

use Yii;
use app\helpers\App;
use app\models\User;
use app\models\VisitLog;
use app\models\search\VisitLogSearch;
use yii\helpers\Inflector;
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
        $model = new VisitLog();
        $post = App::post();

        if (isset($post['process-selected'])) {
            $process = Inflector::humanize($post['process-selected']);
            if (isset($post['selection'])) {

                $models = VisitLog::all($post['selection']);

                if (isset($post['confirm_button'])) {
                    switch ($post['process-selected']) {
                        case 'active':
                            VisitLog::activeAll(['id' => $post['selection']]);
                            break;
                        case 'in_active':
                            VisitLog::inactiveAll(['id' => $post['selection']]);
                            break;
                        case 'delete':
                            VisitLog::deleteAll(['id' => $post['selection']]);
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
        return $this->exportPrint(new VisitLogSearch());
    }

    public function actionExportPdf()
    {
        return $this->exportPdf(new VisitLogSearch());
    }

    public function actionExportCsv()
    {
        return $this->exportCsv(new VisitLogSearch());
    }

    public function actionExportXls()
    {
        return $this->exportXls(new VisitLogSearch());
    }

    public function actionExportXlsx()
    {
        return $this->exportXlsx(new VisitLogSearch());
    }

    public function actionInActiveData()
    {
        # dont delete; use in condition if user has access to in-active data
    }
}