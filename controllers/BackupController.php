<?php

namespace app\controllers;

use Yii;
use app\helpers\App;
use app\models\Backup;
use app\models\search\BackupSearch;
use app\widgets\ExportContent;
use yii\helpers\FileHelper;
use yii\helpers\Inflector;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;

/**
 * BackupController implements the CRUD actions for Backup model.
 */
class BackupController extends Controller
{
    /**
     * Lists all Backup models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new BackupSearch();
        $dataProvider = $searchModel->search(['BackupSearch' => App::queryParams()]);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Backup model.
     * @param integer $slug
     * @return mixed
     * @throws ForbiddenHttpException if the model cannot be found
     */
    public function actionView($slug)
    {
        return $this->render('view', [
            'model' => $this->findModel($slug, 'slug'),
        ]);
    }

    /**
     * Creates a new Backup model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Backup([
            'filename' => time(),
        ]);

        if ($model->load(App::post()) && $model->validate()) {
            $backup = $this->backupDB($model->filename, $model->tables);
            $model->tables = $model->tables ?: App::component('general')->getAllTables();
            
            if ($backup) {
                $model->save();

                $fileInput = new \StdClass();
                $fileInput->baseName = $model->filename;
                $fileInput->extension = 'sql';
                $fileInput->size = $backup['filesize'];

                $file = App::component('file')->saveFile($model, $fileInput, $backup['filepath']);
                $this->checkFileUpload($model, $file->id);
                App::success('Successfully Created');
            }
            else {
                App::danger('Error in creating backup file.');
            }

            return $this->redirect($model->viewUrl);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Duplicates a new Backup model.
     * If duplication is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionDuplicate($slug)
    {
        $originalModel = $this->findModel($slug, 'slug');

        $model = new Backup();
        $model->attributes = $originalModel->attributes;
        
        if ($model->load(App::post()) && $model->validate()) {
            $backup = $this->backupDB($model->filename, $model->tables);
            $model->tables = $model->tables ?: App::component('general')->getAllTables();
            
            if ($backup) {
                $model->save();

                $fileInput = new \StdClass();
                $fileInput->baseName = $model->filename;
                $fileInput->extension = 'sql';
                $fileInput->size = $backup['filesize'];

                App::component('file')->saveFile($model, $fileInput, $backup['filepath']);

                App::success('Successfully Duplicated');
            }
            else {
                App::danger('Error in duplicating backup file.');
            }

            return $this->redirect($model->viewUrl);
        }

        return $this->render('duplicate', [
            'model' => $model,
            'originalModel' => $originalModel,
        ]);
    }
    
    /**
     * Finds the Backup model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Backup the loaded model
     * @throws ForbiddenHttpException if the model cannot be found
     */
    protected function findModel($id, $field='id')
    {
        if (($model = Backup::findOne([$field => $id])) != null) {
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

                $models = Backup::all($post['selection']);

                if (isset($post['confirm_button'])) {
                    switch ($post['process-selected']) {
                        case 'active':
                            Backup::activeAll(['id' => $post['selection']]);
                            break;
                        case 'in_active':
                            Backup::inactiveAll(['id' => $post['selection']]);
                            break;
                        case 'delete':
                            Backup::deleteAll(['id' => $post['selection']]);
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
            'params' => App::get(),
            'file' => $file,
            'searchModel' => new BackupSearch(),
        ]);
    }

    public function actionRestore($slug)
    {
        $model = $this->findModel($slug, 'slug');

        if (!$model || !$model->restore()) {
            App::warning('File don\'t exist or cannot be restored.');
            return $this->redirect(['index']);
        }

        App::success('Restored.');
        return $this->redirect(['index']);
    }

    public function uploadPath($name)
    {
        $folders = [
            'protected',
            'backups',
            date('Y'),
            date('m'),
        ];

        $file_path = implode('/', $folders);
        FileHelper::createDirectory($file_path);


        App::component('file')->createIndexFile($folders);

        $path = "{$file_path}/{$name}.sql";

        return $path;
    }

    public function backupDB($name='', $tables='') 
    {
        $name = $name ?: time();
        $tables = $tables ?: '*';

        $micro_date = microtime();
        $date_array = explode(" ",$micro_date);
        $filepath = $this->uploadPath($name);

        if ($tables == '*') {
            $tables = array();
            $tables = App::getTableNames();
        } 
        else {
            $tables = is_array($tables) ? $tables : explode(',', $tables);
        }
        $return = '';
        foreach ($tables as $table) {
            $result = App::query("SELECT * FROM {$table}");
            $return.= 'DROP TABLE IF EXISTS `' . $table . '`;';
            $row2 = App::queryOne("SHOW CREATE TABLE {$table}");
            $return.= "\n\n" . $row2['Create Table'] . ";\n\n";
            foreach ($result as $row) {
                $return.= 'INSERT INTO ' . $table . ' VALUES(';
                foreach ($row as $data) {
                    $data = addslashes($data);
                    $data = preg_replace("/\n/", "\\n", $data);
                    if (isset($data)) {
                        $return.= "'" . $data . "'";
                    } 
                    else {
                        $return.= '""';
                    }
                    $return.= ',';
                }
                $return = substr($return, 0, strlen($return) - 1);
                $return.= ");\n";
            }
            $return.="\n\n\n";
        }
        $handle = fopen($filepath, 'w+');
        fwrite($handle, $return);
        fclose($handle);

        if (file_exists($filepath)) {

            return [
                'filesize' => filesize($filepath),
                'filepath' => $filepath,
            ];
        }
        return false;
    }

    public function actionDownload($slug)
    {
        $model = $this->findModel($slug, 'slug');
        if (!$model || !$model->download()) {
            App::warning('File don\'t exist or cannot be download');
            return $this->redirect(['index']);
        }
    }

    public function actionInActiveData()
    {
        # dont delete; use in condition if user has access to in-active data
    }
}