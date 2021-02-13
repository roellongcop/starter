<?php

namespace app\controllers;

use Imagine\Gd;
use Imagine\Gd\Imagine;
use Imagine\Image\Box;
use Imagine\Image\BoxInterface;
use Yii;
use app\filters\AccessControl;
use app\filters\IpFilter;
use app\filters\ThemeFilter;
use app\filters\UserFilter;
use app\filters\VerbFilter;
use app\helpers\App;
use app\models\File;
use app\models\ModelFile;
use app\models\form\UploadForm;
use app\models\search\FileSearch;
use app\widgets\ExportContent;
use yii\helpers\ArrayHelper;
use yii\helpers\Inflector;
use yii\imagine\Image;
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
        return [
            'custom' => [
                'class' => UserFilter::className(),
                'class' => IpFilter::className(),
            ],
            'access' => [
                'class' => AccessControl::className(),
                'publicActions' => ['display']
            ],
            'verbs' => [
                'class' => VerbFilter::className()
            ],
            'theme' => [
                'class' => ThemeFilter::className()
            ],
        ];
    } 
    public function actionDisplay($token, $w='', $h='')
    {
        $file = File::findOne(['token' => $token]);
        $crop = App::get('crop')? App::get('crop'): 'false';
        $ratio = App::get('ratio')? App::get('ratio'): 'true';
        $quality = App::get('quality')? App::get('quality'): 100;
        $extension = App::get('extension') ? App::get('extension'): 'png';

        if ($file) { 
            $path = Yii::getAlias('@webroot') . "/{$file->location}";
            if (file_exists($path)) {
                if (in_array($file->extension, App::params('file_extensions')['file'])) {
                    return Yii::$app->response->sendFile($path);
                }
                list($original_width, $original_height) = getimagesize($path);
                $w = ($w)? (int)$w: $original_width ;
                $h = ($h)? (int)$h: $original_height ;
                if ($ratio == 'true') {
                    $imagineObj = new Imagine();
                    $image = $imagineObj->open($path);
                    $image->resize($image->getSize()->widen($w));
                }
                elseif ($crop == 'true') {
                    $image = Image::crop($path, $w, $h); 
                }
                else {
                    $image = Image::getImagine() 
                        ->open($path) 
                        ->resize(new Box($w, $h));
                }
                $image->show($extension, ['quality' => $quality]); 
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
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new File model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new File();

        if ($model->load(App::post()) && $model->save()) {
            App::success('Successfully Created');

            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing File model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws ForbiddenHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(App::post()) && $model->save()) {
            App::success('Successfully Updated');
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing File model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws ForbiddenHttpException if the model cannot be found
     */
    public function actionDelete($id = '')
    {

        if (App::isAjax()) {
            if (($post = App::post()) != null) {
                if (isset($post['fileToken'])) {
                    $file = $this->findModel($post['fileToken'], 'token');
                    if ($file && $file->canDelete) {
                        $file->delete();
                        return 'success';
                    }
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
     * Finds the File model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return File the loaded model
     * @throws ForbiddenHttpException if the model cannot be found
     */
    protected function findModel($id, $field='id')
    {

        if (($model = FileSearch::one($id, $field)) != null) {
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
                return json_encode([
                    'status' => 'success',
                    'attributes' => $model->attributes
                ]);
            }
            else {
                return json_encode([
                    'status' => 'failed',
                    'errors' => $model->errors
                ]);
            }
        }
    }



    public function actionProcessCheckbox()
    {
        $post = App::post();

        if (isset($post['process-selected'])) {
            $process = Inflector::humanize($post['process-selected']);
            if (isset($post['selection'])) {

                $models = FileSearch::all($post['selection']);

                if (isset($post['confirm_button'])) {
                    switch ($post['process-selected']) {
                        case 'active':
                            File::updateAll(
                                ['record_status' => 1],
                                ['id' => $post['selection']]
                            );
                            break;
                        case 'in_active':
                            File::updateAll(
                                ['record_status' => 0],
                                ['id' => $post['selection']]
                            );
                            break;
                        case 'delete':
                            $files = File::findAll(['id' => $post['selection']]);

                            foreach ($files as $file) {
                                $file->delete();
                            }
                            break;
                        default:
                            # code...
                            break;
                    }
                    App::component('logbook')->log(
                        new File(), ArrayHelper::map($models, 'id', 'attributes')
                    );
                    App::success("Data set to '{$process}'");  
                }
                else {
                    return $this->render('confirm_checkbox_process', [
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
        $content = $this->getExportContent('pdf');
        return App::component('export')
            ->export_pdf($content);
    }

    public function actionExportCsv()
    {
        $content = $this->getExportContent();
        App::component('export')
            ->export_csv($content);
    }

    public function actionExportXls()
    {
        $content = $this->getExportContent();
        App::component('export')
            ->export_xls($content);
    }

    public function actionExportXlsx()
    {
        $content = $this->getExportContent();
        App::component('export')
            ->export_xlsx($content);
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
        $result = [];

        if (($post = App::post()) != null) {
            $model = new UploadForm();
            if ($model->load(['UploadForm' => $post])) {
                $model->fileInput = UploadedFile::getInstance($model, 'fileInput');
                $referenceModel = $model->upload();

                $result['status'] = 'success';
                $result['message'] = $referenceModel->imagePath;
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

        return json_encode($result);
    }

    public function actionDownload($token)
    {
        $model = $this->findModel($token, 'token');
        if ($model) {
            $file = $model->location;
            if (file_exists($file)) {
                Yii::$app->response->sendFile($file);

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
        $result = [];

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

        return json_encode($result);
    }
}
