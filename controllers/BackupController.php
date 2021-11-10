<?php

namespace app\controllers;

use Yii;
use app\helpers\App;
use app\jobs\BackupJob;
use app\models\Backup;
use app\models\search\BackupSearch;
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
        $model = $this->findModel($slug, 'slug');

        if (! $model->generated) {
            App::info('The SQL file is currently generating...');
        }
        return $this->render('view', [
            'model' => $model,
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

        if ($model->load(App::post())) {
            if ($model->validate()) {
                $model->tables = $model->tables ?: App::component('general')->getAllTables();
                
                if ($model->save()) {
                    App::queue()->push(new BackupJob([
                        'backupId' => $model->id,
                        'created_by' => App::identity('id')
                    ]));
                    App::success('Successfully Created');
                }
                else {
                    App::danger('Error in creating backup file.');
                }
                return $this->redirect($model->viewUrl);
            }
            else {
                App::danger($model->errorSummary);
            }
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
            $model->tables = $model->tables ?: App::component('general')->getAllTables();
            
            if ($model->save()) {
                App::queue()->push(new BackupJob([
                    'backupId' => $model->id,
                ]));

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
        if (($model = Backup::findVisible([$field => $id])) != null) {
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
                    return $this->render('bulk-action', [
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
        return $this->exportPrint(new BackupSearch());
    }

    public function actionExportPdf()
    {
        return $this->exportPdf(new BackupSearch());
    }

    public function actionExportCsv()
    {
        return $this->exportCsv(new BackupSearch());
    }

    public function actionExportXls()
    {
        return $this->exportXls(new BackupSearch());
    }

    public function actionExportXlsx()
    {
        return $this->exportXlsx(new BackupSearch());
    }

    public function actionRestore($slug)
    {
        $model = $this->findModel($slug, 'slug');

        if (!$model || !$model->restore()) {
            App::warning('File currently don\'t exist or cannot be restored.');
            return $this->redirect(['index']);
        }

        App::success('Restored.');
        return $this->redirect(['index']);
    }

    public function actionDownload($slug)
    {
        $model = $this->findModel($slug, 'slug');
        if (!$model || !$model->download()) {
            App::warning('File currently don\'t exist');
            return $this->redirect(['index']);
        }
    }

    public function actionInActiveData()
    {
        # dont delete; use in condition if user has access to in-active data
    }
}