<?php

namespace app\controllers;

use app\helpers\App;
use app\models\UserMeta;
use app\models\search\UserMetaSearch;

/**
 * UserMetaController implements the CRUD actions for UserMeta model.
 */
class UserMetaController extends Controller
{
    public function actionFindByKeywords($keywords = '')
    {
        return $this->asJson(
            UserMeta::findByKeywords($keywords, ['um.name', 'um.value', 'u.username'])
        );
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
            'model' => UserMeta::controllerFind($id),
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
        $model = UserMeta::controllerFind($id);

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
        $originalModel = UserMeta::controllerFind($id);
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
        $model = UserMeta::controllerFind($id);

        if ($model->delete()) {
            App::success('Successfully Deleted');
        } else {
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
        return $this->exportPrint();
    }

    public function actionExportPdf()
    {
        return $this->exportPdf();
    }

    public function actionExportCsv()
    {
        return $this->exportCsv();
    }

    public function actionExportXls()
    {
        return $this->exportXls();
    }

    public function actionExportXlsx()
    {
        return $this->exportXlsx();
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
            } else {
                $table_columns = json_decode($model->value, true);
            }
            $table_columns[$post['UserMeta']['table_name']] = $post['UserMeta']['columns'] ?? [];
            $model->value = json_encode($table_columns);
            if ($model->save()) {
                $response['status'] = 'success';
                $response['message'] = 'Filtered Column';
            } else {
                $response['status'] = 'failed';
                $response['error'] = $model->errorSummary;
            }
        } else {
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