<?php

namespace app\controllers;

use Yii;
use app\widgets\ExportContent;
use app\models\Visitor;
use app\models\search\VisitorSearch;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use app\helpers\App;
use yii\helpers\Inflector;

/**
 * VisitorController implements the CRUD actions for Visitor model.
 */
class VisitorController extends Controller 
{
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
     * Creates a new Visitor model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Visitor();

        if ($model->load(App::post()) && $model->save()) {
            App::success('Successfully Created');

            return $this->redirect($model->viewUrl);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Duplicates a new Visitor model.
     * If duplication is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionDuplicate($cookie)
    {
        $originalModel = $this->findModel($cookie, 'cookie');
        $model = new Visitor();
        $model->attributes = $originalModel->attributes;

        if ($model->load(App::post()) && $model->save()) {
            App::success('Successfully Duplicated');

            return $this->redirect($model->viewUrl);
        }

        return $this->render('duplicate', [
            'model' => $model,
            'originalModel' => $originalModel,
        ]);
    }

    /**
     * Updates an existing Visitor model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $cookie
     * @return mixed
     * @throws ForbiddenHttpException if the model cannot be found
     */
    public function actionUpdate($cookie)
    {
        $model = $this->findModel($cookie, 'cookie');

        if ($model->load(App::post()) && $model->save()) {
            App::success('Successfully Updated');
            return $this->redirect($model->viewUrl);
        }

        return $this->render('update', [
            'model' => $model,
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

        return $this->redirect(['index']);
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
        if (($post = App::post()) != null) {
            $model = $this->findModel($post['id']);
            $model->record_status = $post['record_status'];

            if ($model->save()) {
                $model->refresh();
                return $this->asJson([
                    'status' => 'success',
                    'attributes' => $model->attributes
                ]);
            }
            else {
                return $this->asJson([
                    'status' => 'failed',
                    'errors' => $model->errors,
                    'errorSummary' => $model->errorSummary
                ]);
            }
        }
    }

    public function actionConfirmAction()
    {
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
                    return $this->render('confirm-action', [
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

        return $this->redirect(['index']);
    }

    public function actionPrint()
    {
        $this->layout = 'print';
        return $this->render('_print', [
            'content' => $this->getExportContent('pdf')
        ]);
    }

    public function actionExportPdf()
    {
        return App::export()->pdf(
            $this->getExportContent('pdf')
        );
    }

    public function actionExportCsv()
    {
        return App::export()->csv(
            $this->getExportContent()
        );
    }

    public function actionExportXls()
    {
        return App::export()->xls(
            $this->getExportContent()
        );
    }

    public function actionExportXlsx()
    {
        return App::export()->xlsx(
            $this->getExportContent()
        );
    }

    protected function getExportContent($file='excel')
    {
        return ExportContent::widget([
            'params'      => App::get(),
            'file'        => $file,
            'searchModel' => new VisitorSearch(),
        ]);
    }

    public function actionInActiveData()
    {
        # dont delete; use in condition if user has access to in-active data
    }
}