<?php

namespace app\controllers;

use Yii;
use app\helpers\App;
use app\models\Role;
use app\models\search\RoleSearch;

/**
 * RoleController implements the CRUD actions for Role model.
 */
class RoleController extends Controller
{
    public function actionFindByKeywords($keywords='')
    {
        return $this->asJson(
            Role::findByKeywords($keywords, ['name'])
        );
    }
    
    /**
     * Lists all Role models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new RoleSearch();
        $dataProvider = $searchModel->search(['RoleSearch' => App::queryParams()]);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Role model.
     * @param integer $id
     * @return mixed
     * @throws ForbiddenHttpException if the model cannot be found
     */
    public function actionView($slug)
    {
        return $this->render('view', [
            'model' => Role::controllerFind($slug, 'slug'),
        ]);
    }

    /**
     * Creates a new Role model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Role();

        if ($model->load(App::post()) && $model->save()) {
            if ($model->save()) {
                App::success('Successfully Created');
                return $this->redirect($model->viewUrl);
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Duplicates an existing Role model.
     * If duplication is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws ForbiddenHttpException if the model cannot be found
     */
    public function actionDuplicate($slug)
    {
        $originalModel = Role::controllerFind($slug, 'slug');
        $model = new Role();
        $model->attributes = $originalModel->attributes;

        if (($post = App::post()) != null) {
            $post['Role']['main_navigation'] = $post['Role']['main_navigation'] ?? null;
            $post['Role']['role_access'] = $post['Role']['role_access'] ?? null;
            $post['Role']['module_access'] = $post['Role']['module_access'] ?? null;

            if ($model->load($post) && $model->save()) {
                App::success('Successfully Duplicated');
                return $this->redirect($model->viewUrl);
            }
        }

        return $this->render('duplicate', [
            'model' => $model,
            'originalModel' => $originalModel,
        ]);
    }

    /**
     * Updates an existing Role model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws ForbiddenHttpException if the model cannot be found
     */
    public function actionUpdate($slug)
    {
        $model = Role::controllerFind($slug, 'slug');

        if (($post = App::post()) != null) {
            $post['Role']['main_navigation'] = $post['Role']['main_navigation'] ?? null;
            $post['Role']['role_access'] = $post['Role']['role_access'] ?? null;
            $post['Role']['module_access'] = $post['Role']['module_access'] ?? null;

            if ($model->load($post) && $model->save()) {
                App::success('Successfully Updated');
                return $this->redirect($model->viewUrl);
            }
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Role model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws ForbiddenHttpException if the model cannot be found
     */
    public function actionDelete($slug)
    {
        $model = Role::controllerFind($slug, 'slug');

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

    public function actionMyRole()
    {
        $model = App::identity('role');

        if ($model->load(App::post()) && $model->validate()) {
            $post = App::post();
            $model->load($post);
            if (empty($post['Role']['main_navigation'])) {
                $model->main_navigation = null;
            }
            if (empty($post['Role']['role_access'])) {
                $model->role_access = null;
            }
            if (empty($post['Role']['module_access'])) {
                $model->module_access = null;
            }
            if ($model->save()) {
                App::success('Successfully Updated');
                return $this->refresh();
            }
        }

        return $this->render('my_role', [
            'model' => $model,
        ]);
    }

    public function actionInActiveData()
    {
        # dont delete; use in condition if user has access to in-active data
    }
}