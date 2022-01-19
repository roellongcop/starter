<?php

namespace app\controllers;

use Yii;
use app\helpers\App;
use app\models\Visitor;
use app\models\search\VisitorSearch;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use yii\helpers\Inflector;

/**
 * VisitorController implements the CRUD actions for Visitor model.
 */
class VisitorController extends Controller 
{
    public function actionFindByKeyword($keyword='')
    { 
        return $this->asJson(
            Visitor::findByKeyword($keyword, [
                'expire',
                'cookie',
                'ip',
                'browser',
                'os',
                'device',
                'location',
            ])
        );
    }

    /**
     * Lists all Visitor models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new VisitorSearch();
        $dataProvider = $searchModel->search(['VisitorSearch' => App::queryParams()]);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Visitor model.
     * @param string $cookie
     * @return mixed
     * @throws ForbiddenHttpException if the model cannot be found
     */
    public function actionView($cookie)
    {
        return $this->render('view', [
            'model' => $this->findModel($cookie, 'cookie'),
        ]);
    }
 
    /**
     * Deletes an existing Visitor model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $cookie
     * @return mixed
     * @throws ForbiddenHttpException if the model cannot be found
     */
    public function actionDelete($cookie)
    {
        $model = $this->findModel($cookie, 'cookie');

        if($model->delete()) {
            App::success('Successfully Deleted');
        }
        else {
            App::danger(json_encode($model->errors));
        }

        return $this->redirect($model->indexUrl);
    }

    /**
     * Finds the Visitor model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Visitor the loaded model
     * @throws ForbiddenHttpException if the model cannot be found
     */
    protected function findModel($id, $field='id')
    {
        if (($model = Visitor::findVisible([$field => $id])) != null) {
            if (App::modelCan($model)) {
                return $model;
            }
            throw new ForbiddenHttpException('Forbidden action to data');
        }
        
        throw new NotFoundHttpException('Page not found.');
    }

    public function actionChangeRecordStatus()
    {
        return $this->changeRecordStatus();
    }

    public function actionBulkAction()
    {
        $model = new Visitor();
        $post = App::post();

        if (isset($post['process-selected'])) {
            $process = Inflector::humanize($post['process-selected']);
            if (isset($post['selection'])) {

                $models = Visitor::all($post['selection']);

                if (isset($post['confirm_button'])) {
                    switch ($post['process-selected']) {
                        case 'active':
                            Visitor::activeAll(['id' => $post['selection']]);
                            break;
                        case 'in_active':
                            Visitor::inactiveAll(['id' => $post['selection']]);
                            break;
                        case 'delete':
                            Visitor::deleteAll(['id' => $post['selection']]);
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
        return $this->exportPrint(new VisitorSearch());
    }

    public function actionExportPdf()
    {
        return $this->exportPdf(new VisitorSearch());
    }

    public function actionExportCsv()
    {
        return $this->exportCsv(new VisitorSearch());
    }

    public function actionExportXls()
    {
        return $this->exportXls(new VisitorSearch());
    }

    public function actionExportXlsx()
    {
        return $this->exportXlsx(new VisitorSearch());
    }

    public function actionInActiveData()
    {
        # dont delete; use in condition if user has access to in-active data
    }
}