<?php

namespace app\controllers;

use Yii;
use app\helpers\App;
use app\jobs\BackupJob;
use app\models\Backup;
use app\models\Queue;
use app\models\search\BackupSearch;

/**
 * BackupController implements the CRUD actions for Backup model.
 */
class BackupController extends Controller
{
    public function actionFindByKeywords($keywords='')
    {
        return $this->asJson(
            Backup::findByKeywords($keywords, ['filename', 'tables', 'description'])
        );
    }
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
        $model = Backup::controllerFind($slug, 'slug');

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
                    Queue::push(new BackupJob([
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
        $originalModel = Backup::controllerFind($slug, 'slug');

        $model = new Backup();
        $model->attributes = $originalModel->attributes;
        
        if ($model->load(App::post()) && $model->validate()) {
            $model->tables = $model->tables ?: App::component('general')->getAllTables();
            
            if ($model->save()) {
                Queue::push(new BackupJob([
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
        $model = Backup::controllerFind($slug, 'slug');

        if (!$model || !$model->restore()) {
            App::warning('File currently don\'t exist or cannot be restored.');
            return $this->redirect($model->indexUrl);
        }

        App::success('Restored.');
        return $this->redirect($model->indexUrl);
    }

    public function actionDownload($slug)
    {
        $model = Backup::controllerFind($slug, 'slug');
        if (!$model || !$model->download()) {
            App::warning('File currently don\'t exist');
            return $this->redirect($model->indexUrl);
        }
    }

    public function actionInActiveData()
    {
        # dont delete; use in condition if user has access to in-active data
    }
}