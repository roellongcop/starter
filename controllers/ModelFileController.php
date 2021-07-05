<?php

namespace app\controllers;

use Yii;
use app\widgets\ExportContent;
use app\models\ModelFile;
use app\models\search\ModelFileSearch;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use app\helpers\App;
use yii\helpers\Inflector;

/**
 * ModelFileController implements the CRUD actions for ModelFile model.
 */
class ModelFileController extends Controller 
{
    /**
     * Lists all ModelFile models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ModelFileSearch();
        $dataProvider = $searchModel->search(['ModelFileSearch' => App::queryParams()]);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single ModelFile model.
     * @param integer $id
     * @return mixed
     * @throws ForbiddenHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Deletes an existing ModelFile model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws ForbiddenHttpException if the model cannot be found
     */
    public function actionDelete($id='')
    {
        if (App::isAjax()) {
            if (($post = App::post()) != null) {

                if (isset($post['file_id'])) {
                    $return = [];

                    $modelFile = ModelFile::find()
                        ->where([
                            'file_id' => $post['file_id'],
                            'model_id' => $post['model_id'],
                            'model_name' => $post['model_name'],
                        ])
                        ->one();

                    if ($modelFile) {
                        if ($modelFile->canDelete) {
                            $modelFile->delete();
                            $return['status'] = 'success';
                            $return['message'] = 'Image Deleted.';
                        }
                        else {
                            $return['status'] = 'error';
                            $return['message'] = 'Image cannot be deleted.';
                        }
                    }
                    else {
                        $return['status'] = 'error';
                        $return['message'] = 'Image not found.';
                    }
                    return json_encode($return);
                }
            }

            return ;
        }
        $model = $this->findModel($id);

        if($model->delete()) {
            App::success('Successfully Deleted');
        }
        else {
            App::danger(json_encode($model->errors));
        }

        return $this->redirect(['index']);
    }

    /**
     * Finds the ModelFile model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ModelFile the loaded model
     * @throws ForbiddenHttpException if the model cannot be found
     */
    protected function findModel($id, $field='id')
    {
        if (($model = ModelFile::findOne([$field => $id])) != null) {
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

                $models = ModelFile::all($post['selection']);

                if (isset($post['confirm_button'])) {
                    switch ($post['process-selected']) {
                        case 'active':
                            ModelFile::activeAll(['id' => $post['selection']]);
                            break;
                        case 'in_active':
                            ModelFile::inactiveAll(['id' => $post['selection']]);
                            break;
                        case 'delete':
                            ModelFile::deleteAll(['id' => $post['selection']]);
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
            'searchModel' => new ModelFileSearch(),
        ]);
    }

    public function actionInActiveData()
    {
        # dont delete; use in condition if user has access to in-active data
    }
}