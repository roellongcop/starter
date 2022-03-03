<?php

namespace app\controllers;

use Yii;
use app\helpers\App;
use app\models\User;
use app\models\UserMeta;
use app\models\search\UserMetaSearch;
use yii\helpers\ArrayHelper;
use yii\helpers\Inflector;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;

/**
 * UserMetaController implements the CRUD actions for UserMeta model.
 */
class UserMetaController extends Controller
{
    public function actionFindByKeywords($keywords='')
    { 
        $data = array_merge(
            UserMeta::findByKeywords($keywords, ['name', 'value']), 
            UserMeta::users()
        );

        $data = array_unique($data);
        $data = array_values($data);
        sort($data);

        return $this->asJson($data);
    }

    /**
     * Lists all UserMeta models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new UserMetaSearch();
        $dataProvider = $searchModel->search(['UserMetaSearch' => App::queryParams()]);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single UserMeta model.
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
     * Creates a new UserMeta model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new UserMeta();

        if ($model->load(App::post()) && $model->save()) {
            App::success('Successfully Created');

            return $this->redirect($model->viewUrl);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing UserMeta model.
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
            return $this->redirect($model->viewUrl);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Duplicates an existing UserMeta model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws ForbiddenHttpException if the model cannot be found
     */
    public function actionDuplicate($id)
    {
        $originalModel = $this->findModel($id);
        $model = new UserMeta();
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
     * Deletes an existing UserMeta model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws ForbiddenHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);

        if($model->delete()) {
            App::success('Successfully Deleted');
        }
        else {
            App::danger(json_encode($model->errors));
        }

        return $this->redirect($model->indexUrl);
    }

    /**
     * Finds the UserMeta model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return UserMeta the loaded model
     * @throws ForbiddenHttpException if the model cannot be found
     */
    protected function findModel($id, $field='id')
    {
        if (($model = UserMeta::findVisible([$field => $id])) != null) {
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
        $model = new UserMeta();
        $post = App::post();

        if (isset($post['process-selected'])) {
            $process = Inflector::humanize($post['process-selected']);
            if (isset($post['selection'])) {

                $models = UserMeta::all($post['selection']);

                if (isset($post['confirm_button'])) {
                    switch ($post['process-selected']) {
                        case 'active':
                            UserMeta::activeAll(['id' => $post['selection']]);
                            break;
                        case 'in_active':
                            UserMeta::inactiveAll(['id' => $post['selection']]);
                            break;
                        case 'delete':
                            UserMeta::deleteAll(['id' => $post['selection']]);
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
        return $this->exportPrint(new UserMetaSearch());
    }

    public function actionExportPdf()
    {
        return $this->exportPdf(new UserMetaSearch());
    }

    public function actionExportCsv()
    {
        return $this->exportCsv(new UserMetaSearch());
    }

    public function actionExportXls()
    {
        return $this->exportXls(new UserMetaSearch());
    }

    public function actionExportXlsx()
    {
        return $this->exportXlsx(new UserMetaSearch());
    }

    public function actionFilter()
    {
        $response = [];

        if (($post = App::post()) != null) {
            $model = UserMeta::findOne([
                'user_id' => App::identity('id'),
                'name' => 'table_columns',
            ]);

            $model = $model ?: new UserMeta();

            if ($model->isNewRecord) {
                $model->user_id = App::identity('id');
                $model->name = 'table_columns';
            }
            else {
                $table_columns = json_decode($model->value, true);
            }
            $table_columns[$post['UserMeta']['table_name']] = $post['UserMeta']['columns'] ?? [];
            $model->value = json_encode($table_columns);
            if ($model->save()) {
                $response['status'] = 'success';
                $response['message'] = 'Filtered Column';
            }
            else {
                $response['status'] = 'failed';
                $response['error'] = $model->errorSummary;
            }
        }
        else {
            $response['status'] = 'failed';
            $response['error'] = 'No post data';
        }
        return $this->asJson($response);
    }

    public function actionInActiveData()
    {
        # dont delete; use in condition if user has access to in-active data
    }
}