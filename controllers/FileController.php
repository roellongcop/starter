<?php

namespace app\controllers;

use Yii;
use app\helpers\App;
use app\models\File;
use app\models\form\UploadForm;
use app\models\search\FileSearch;
use yii\helpers\Inflector;
use yii\web\UploadedFile;
/**
 * FileController implements the CRUD actions for File model.
 */
class FileController extends Controller
{
    public function actionFindByKeywords($keywords='')
    {
        return $this->asJson(
            File::findByKeywords($keywords, ['name', 'extension', 'token'])
        );
    }

    public function actionFindByKeywordsImage($keywords='')
    {
        return $this->asJson(
            File::findByKeywordsImage($keywords, ['name', 'extension', 'token'])
        );
    }
     
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['AccessControl'] = [
            'class' => 'app\filters\AccessControl',
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

        $file = File::findByToken($token) ?: File::findByToken(App::setting('image')->image_holder);

        if ($file) { 

            if (file_exists($file->displayRootPath)) {
                    
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

        return File::IMAGE_HOLDER;
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
            'model' => File::controllerFind($token, 'token'),
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
        $model = File::controllerFind($token, 'token');

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
        return $this->exportPrint(new FileSearch());
    }

    public function actionExportPdf()
    {
        return $this->exportPdf(new FileSearch());
    }

    public function actionExportCsv()
    {
        return $this->exportCsv(new FileSearch());
    }

    public function actionExportXls()
    {
        return $this->exportXls(new FileSearch());
    }

    public function actionExportXlsx()
    {
        return $this->exportXlsx(new FileSearch());
    }

    public function actionUpload()
    {
        if (($post = App::post()) != null) {
            $model = new UploadForm();
            if ($model->load($post)) {

                $model->fileInput = UploadedFile::getInstance($model, 'fileInput');
                if (($file = $model->upload()) != false) {
                    $file->refresh();

                    $result['status'] = 'success';
                    $result['message'] = 'Uploaded';
                    $result['src'] = $file->display;
                    $result['file'] = $file;
                }
                else {
                    $result['status'] = 'error';
                    $result['message'] = 'Upload Error';
                    $result['errors'] = $model->errors;
                }
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
        $model = File::controllerFind($token, 'token');
        if ($model->download()) {
            
        }
        else {
            App::warning('File don\'t exist');
            return $this->redirect(App::referrer());
        }
    }
 
    public function actionInActiveData()
    {
        # dont delete; use in condition if user has access to in-active data
    }

    public function actionMyImageFiles()
    {
        $searchModel = new FileSearch([
            'extension' => File::EXTENSIONS['image'],
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