<?php

namespace app\controllers;

use Yii;
use app\helpers\App;
use app\models\Theme;
use app\models\form\user\MySettingForm;
use app\models\search\ThemeSearch;

/**
 * ThemeController implements the CRUD actions for Theme model.
 */
class ThemeController extends Controller 
{
    public function actionFindByKeywords($keywords='')
    { 
        return $this->asJson(
            Theme::findByKeywords($keywords, ['name', 'description'])
        );
    }

    /**
     * Lists all Theme models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ThemeSearch();
        $dataProvider = $searchModel->search(['ThemeSearch' => App::queryParams()]);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Theme model.
     * @param integer $id
     * @return mixed
     * @throws ForbiddenHttpException if the model cannot be found
     */
    public function actionView($slug)
    {
        return $this->render('view', [
            'model' => Theme::controllerFind($slug, 'slug'),
        ]);
    }

    /**
     * Creates a new Theme model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Theme();

        if ($model->load(App::post()) && $model->save()) {
            App::success('Successfully Created');
            return $this->redirect($model->viewUrl);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Duplicates a new Ip model.
     * If duplication is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionDuplicate($slug)
    {
        $originalModel = Theme::controllerFind($slug, 'slug');
        $model = new Theme();
        $model->attributes = $originalModel->attributes;

        if (($post = App::post()) != null) {
            $post['Theme']['photos'] = $post['Theme']['photos'] ?? null;

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
     * Updates an existing Theme model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $slug
     * @return mixed
     * @throws ForbiddenHttpException if the model cannot be found
     */
    public function actionUpdate($slug)
    {
        $model = Theme::controllerFind($slug, 'slug');

        if (($post = App::post()) != null) {
            $post['Theme']['photos'] = $post['Theme']['photos'] ?? null;

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
     * Deletes an existing Theme model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $slug
     * @return mixed
     * @throws ForbiddenHttpException if the model cannot be found
     */
    public function actionDelete($slug)
    {
        $model = Theme::controllerFind($slug, 'slug');

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
        return $this->exportPrint(new ThemeSearch());
    }

    public function actionExportPdf()
    {
        return $this->exportPdf(new ThemeSearch());
    }

    public function actionExportCsv()
    {
        return $this->exportCsv(new ThemeSearch());
    }

    public function actionExportXls()
    {
        return $this->exportXls(new ThemeSearch());
    }

    public function actionExportXlsx()
    {
        return $this->exportXlsx(new ThemeSearch());
    }

    public function actionActivate($slug)
    {
        $theme = Theme::controllerFind($slug, 'slug');

        $model = new MySettingForm(['user_id' => App::identity('id')]);
        $model->theme_id = $theme->id;

       if ( $model->save()) {
            App::success('Theme Changed.');
       }
       else {
            App::danger($model->errors);
       }

       return $this->redirect(App::referrer());
    }

    public function actionInActiveData()
    {
        # dont delete; use in condition if user has access to in-active data
    }
}