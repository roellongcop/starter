<?php

namespace app\controllers;

use Yii;
use app\helpers\App;
use app\models\Backup;
use app\models\Log;
use app\models\search\BackupSearch;
use app\widgets\ExportContent;
use yii\helpers\ArrayHelper;
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

                App::component('file')->saveFile($model, $fileInput, $backup['filepath']);

                App::success('Successfully Created');
            }
            else {
                App::danger('Error in creating backup file.');
            }

            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Backup model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws ForbiddenHttpException if the model cannot be found
     */
    /*ublic function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(App::post()) && $model->save()) {
            App::success('Successfully Updated');
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }*/

    /**
     * Deletes an existing Backup model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws ForbiddenHttpException if the model cannot be found
     */
    // ublic function actionDelete($id)
    // {
    //     $model = $this->findModel($id);

    //     if($model->delete()) {
    //         App::success('Successfully Deleted');
    //     }
    //     else {
    //         App::danger(json_encode($model->errors));
    //     }

    //     return $this->redirect(['index']);
    // }

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

                $models = Backup::all($post['selection']);

                if (isset($post['confirm_button'])) {
                    switch ($post['process-selected']) {
                        case 'active':
                            Backup::updateAll(
                                ['record_status' => 1],
                                ['id' => $post['selection']]
                            );
                            break;
                        case 'in_active':
                            Backup::updateAll(
                                ['record_status' => 0],
                                ['id' => $post['selection']]
                            );
                            break;
                        case 'delete':
                            Backup::deleteAll(['id' => $post['selection']]);
                            break;
                        default:
                            # code...
                            break;
                    }
                    Log::record(new Backup(), ArrayHelper::map($models, 'id', 'attributes'));
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
            'searchModel' => new BackupSearch(),
        ]);
    }


    public function actionRestore($id)
    {
        $model = $this->findModel($id);

        $sql = file_get_contents($model->sqlFileLocation);
        App::execute($sql);

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
                        $return.= '"' . $data . '"';
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

    public function actionDownload($id)
    {
        $model = $this->findModel($id);
        if ($model) {
            $model->download();
        }
        else {
            App::warning('File don\'t exist');
            return $this->redirect(['index']);
        }
    }

    public function actionInActiveData()
    {
        # dont delete; use in condition if user has access to in-active data
    }
}
