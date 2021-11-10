<?php

namespace app\controllers;

use Yii;
use app\helpers\App;
use app\models\Role;
use app\models\search\RoleSearch;
use yii\helpers\Inflector;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;

/**
 * RoleController implements the CRUD actions for Role model.
 */
class RoleController extends Controller
{
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
            'model' => $this->findModel($slug, 'slug'),
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

        if ($model->load(App::post()) && $model->validate()) {

            $post = App::post();
            if (empty($post['Role']['main_navigation'])) {
                $model->main_navigation = NULL;
            }
            if (empty($post['Role']['role_access'])) {
                $model->role_access = NULL;
            }
            if (empty($post['Role']['module_access'])) {
                $model->module_access = NULL;
            }
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
        $originalModel = $this->findModel($slug, 'slug');
        $model = new Role();
        $model->attributes = $originalModel->attributes;

        if ($model->load(App::post()) && $model->validate()) {

            $post = App::post();
            $model->load($post);
            if (empty($post['Role']['main_navigation'])) {
                $model->main_navigation = NULL;
            }
            if (empty($post['Role']['role_access'])) {
                $model->role_access = NULL;
            }
            if (empty($post['Role']['module_access'])) {
                $model->module_access = NULL;
            }
            if ($model->save()) {
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
        $model = $this->findModel($slug, 'slug');

        if ($model->load(App::post()) && $model->validate()) {

            $post = App::post();
            $model->load($post);
            if (empty($post['Role']['main_navigation'])) {
                $model->main_navigation = NULL;
            }
            if (empty($post['Role']['role_access'])) {
                $model->role_access = NULL;
            }
            if (empty($post['Role']['module_access'])) {
                $model->module_access = NULL;
            }
            if ($model->save()) {
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
        $model = $this->findModel($slug, 'slug');

        if($model->delete()) {
            App::success('Successfully Deleted');
        }
        else {
            App::danger(json_encode($model->errors));
        }

        return $this->redirect($model->indexUrl);
    }

    /**
     * Finds the Role model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Role the loaded model
     * @throws ForbiddenHttpException if the model cannot be found
     */
    protected function findModel($id, $field='id')
    {
        if (($model = Role::findVisible([$field => $id])) != null) {
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
        $model = new Role();
        $post = App::post();

        if (isset($post['process-selected'])) {
            $process = Inflector::humanize($post['process-selected']);
            if (isset($post['selection'])) {

                $models = Role::all($post['selection']);

                if (isset($post['confirm_button'])) {
                    switch ($post['process-selected']) {
                        case 'active':
                            Role::activeAll(['id' => $post['selection']]);
                            break;
                        case 'in_active':
                            Role::inactiveAll(['id' => $post['selection']]);
                            break;
                        case 'delete':
                            Role::deleteAll(['id' => $post['selection']]);
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
        return $this->exportPrint(new RoleSearch());
    }

    public function actionExportPdf()
    {
        return $this->exportPdf(new RoleSearch());
    }

    public function actionExportCsv()
    {
        return $this->exportCsv(new RoleSearch());
    }

    public function actionExportXls()
    {
        return $this->exportXls(new RoleSearch());
    }

    public function actionExportXlsx()
    {
        return $this->exportXlsx(new RoleSearch());
    }

    public function actionMyRole()
    {
        $model = App::identity('role');

        if ($model->load(App::post()) && $model->validate()) {
            $post = App::post();
            $model->load($post);
            if (empty($post['Role']['main_navigation'])) {
                $model->main_navigation = NULL;
            }
            if (empty($post['Role']['role_access'])) {
                $model->role_access = NULL;
            }
            if (empty($post['Role']['module_access'])) {
                $model->module_access = NULL;
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