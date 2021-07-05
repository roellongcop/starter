<?php

namespace app\controllers;

use Yii;
use app\filters\AccessControl;
use app\helpers\App;
use app\models\File;
use app\models\ModelFile;
use app\models\form\UploadForm;
use app\models\search\FileSearch;
use app\widgets\ExportContent;
use yii\helpers\Inflector;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;
/**
 * FileController implements the CRUD actions for File model.
 */
class FileController extends Controller
{
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['AccessControl'] = [
            'class' => AccessControl::className(),
            'publicActions' => ['display', 'upload', 'download']
        ];

        if (App::isAction('display')) {
            unset(
                $behaviors['UserFilter'],
                $behaviors['ThemeFilter'],
                $behaviors['SettingFilter'],
            );
        }

        return $behaviors;
    }
    
    public function actionDisplay($token='')
    {
        $w = App::get('w') ?: '';
        $h = App::get('h') ?: '';
        $crop = App::get('crop') ?: 'false';
        $ratio = App::get('ratio') ?: 'true';
        $quality = App::get('quality') ?: 100;
        $extension = App::get('extension') ?: 'png';

        $file = File::findOne(['token' => $token]);

        if ($file) { 
            $path = $file->rootPath;

            if (file_exists($path)) {
                if ($file->isDocument) {
                    return App::response()->sendFile($path);
                }
                elseif ($file->isImage) {
                    
                    $w = ($w)? (int)$w: $file->width;
                    $h = ($h)? (int)$h: $file->height;

                    if ($ratio == 'true') {
                        return $file->getImageRatio($w, $quality, $extension);
                    }
                    elseif ($crop == 'true') {
                        return $file->getImageCrop($w, $h, $quality, $extension);
                    }
                    else {
                        return $file->getImage($w, $h, $quality, $extension);
                    }
                }
            }
        }
    }

    /**
     * Lists all File models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new FileSearch();
        $dataProvider = $searchModel->search(['FileSearch' => App::queryParams()]);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single File model.
     * @param integer $id
     * @return mixed
     * @throws ForbiddenHttpException if the model cannot be found
     */
    public function actionView($token)
    {
        return $this->render('view', [
            'model' => $this->findModel($token, 'token'),
        ]);
    }

    /**
     * Deletes an existing File model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws ForbiddenHttpException if the model cannot be found
     */
    public function actionDelete($token = '')
    {
        $model = $this->findModel($token, 'token');

        if (App::isAjax()) {
            if ($model && $model->canDelete) {
                $file = $model;
                if ($model->delete()) {
                    return $this->asJson([
                        'status' => 'success',
                        'file' => $file,
                        'message' => 'File Deleted'
                    ]);
                }

                return $this->asJson([
                    'status' => 'failed',
                    'errors' => $model->errors
                ]);
            }

            return $this->asJson([
                'status' => 'failed',
                'errors' => 'File not found or file cannot be deleted'
            ]);
        }

        if($model->delete()) {
            App::success('Successfully Deleted');
        }
        else {
            App::danger(json_encode($model->errors));
        }

        return $this->redirect(['index']);
    }

    /**
     * Finds the File model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return File the loaded model
     * @throws ForbiddenHttpException if the model cannot be found
     */
    protected function findModel($id, $field='id')
    {
        if (($model = File::findOne([$field => $id])) != null) {
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

                $models = File::all($post['selection']);

                if (isset($post['confirm_button'])) {
                    switch ($post['process-selected']) {
                        case 'active':
                            File::activeAll(['id' => $post['selection']]);
                            break;
                        case 'in_active':
                            File::inactiveAll(['id' => $post['selection']]);
                            break;
                        case 'delete':
                            File::deleteAll(['id' => $post['selection']]);
                            break;
                        default:
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
            'params' => App::get(),
            'file' => $file,
            'searchModel' => new FileSearch(),
        ]);
    }

    public function actionUpload()
    {
        if (($post = App::post()) != null) {
            $model = new UploadForm();
            if ($model->load(['UploadForm' => $post])) {
                $model->fileInput = UploadedFile::getInstance($model, 'fileInput');
                $file = $model->upload();

                $file->refresh();

                $result['status'] = 'success';
                $result['message'] = 'Uploaded';
                $result['src'] = $file->imagePath;
                $result['file'] = $file;
            }
            else {
                $result['status'] = 'error';
                $result['message'] = 'Form not valid';
            }
        }
        else {
            $result['status'] = 'error';
            $result['message'] = 'no form data';
        }

        return $this->asJson($result);
    }

    public function actionDownload($token)
    {
        $model = $this->findModel($token, 'token');
        if ($model) {
            $file = $model->location;
            if (file_exists($file)) {
                App::response()->sendFile($file);

                return true;
            }
            return false;
        }
        else {
            App::warning('File don\'t exist');
            return $this->redirect(App::referrer());
        }
    }

    public function actionChangePhoto()
    {
        if (App::isAjax() && (($post = App::post()) != null)) {
            $file = $this->findModel($post['file_id']);

            if ($file) {
                $modelFile = new ModelFile();
                $modelFile->model_name = $post['modelName'];
                $modelFile->model_id = $post['model_id'];
                $modelFile->file_id = $file->id;
                if ($modelFile->save()) {
                    $result['status'] = 'success';
                    $result['message'] = 'File added';
                    $result['src'] = $file->imagePath;
                    $result['model_file_id'] = $modelFile->id;
                }
                else {
                    $result['status'] = 'error';
                    $result['message'] = json_encode($modelFile->errors);
                }
            }
            else {
                $result['status'] = 'error';
                $result['message'] = 'No file selected';
            }
        }
        else {
            $result['status'] = 'error';
            $result['message'] = 'Request value not found.';
        }

        return $this->asJson($result);
    }

    public function actionInActiveData()
    {
        # dont delete; use in condition if user has access to in-active data
    }

    public function actionMyImageFiles()
    {
        $searchModel = new FileSearch([
            'extension' => App::params('file_extensions')['image'],
            'created_by' => App::identity('id')
        ]);

        $searchModel->pagination = 12;
        $dataProvider = $searchModel->search(['FileSearch' => App::queryParams()]);
        $dataProvider->query->groupBy(['name', 'size', 'extension']);

        $data = [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ];

        if (App::isAjax()) {
            return $this->renderPartial('my-image-files-ajax', $data);
        }


        return $this->render('my-image-files', $data); 
    }

    public function actionMyFiles()
    {
        $searchModel = new FileSearch([
            'created_by' => App::identity('id')
        ]);

        $searchModel->pagination = 12;
        $dataProvider = $searchModel->search(['FileSearch' => App::queryParams()]);
        $dataProvider->query->groupBy(['name', 'size', 'extension']);

        $data = [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ];

        if (App::isAjax()) {
            return $this->renderPartial('my-files-ajax', $data);
        }

        return $this->render('my-files', $data); 
    }
}