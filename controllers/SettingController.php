<?php

namespace app\controllers;

use app\helpers\App;
use app\models\Setting;
use app\models\Theme;
use app\models\form\setting\EmailSettingForm;
use app\models\form\setting\GeneralSettingForm;
use app\models\form\setting\ImageSettingForm;
use app\models\form\setting\NotificationSettingForm;
use app\models\form\setting\SystemSettingForm;
use app\models\form\user\MySettingForm;
use app\models\search\SettingSearch;

/**
 * SettingController implements the CRUD actions for Setting model.
 */
class SettingController extends Controller
{
    public function actionFindByKeywords($keywords = '')
    {
        return $this->asJson(
            Setting::findByKeywords($keywords, ['name', 'value'])
        );
    }

    /**
     * Lists all Setting models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SettingSearch();
        $dataProvider = $searchModel->search(['SettingSearch' => App::queryParams()]);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Setting model.
     * @param integer $id
     * @return mixed
     * @throws ForbiddenHttpException if the model cannot be found
     */
    public function actionView($name)
    {
        return $this->render('view', [
            'model' => Setting::controllerFind($name, 'name'),
        ]);
    }

    /**
     * Updates an existing Setting model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws ForbiddenHttpException if the model cannot be found
     */
    public function actionUpdate($name)
    {
        $model = Setting::controllerFind($name, 'name');

        if ($model->load(App::post()) && $model->save()) {
            App::success('Successfully Updated');
            return $this->redirect($model->viewUrl);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Setting model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws ForbiddenHttpException if the model cannot be found
     */
    public function actionDelete($name)
    {
        $model = Setting::controllerFind($name, 'name');

        if ($model->delete()) {
            App::success('Successfully Deleted');
        } else {
            App::danger(json_encode($model->errors));
        }

        return $this->redirect($model->indexUrl);
    }

    public function actionMySetting()
    {
        if (App::isLogin()) {
            $user = App::identity();
            $model = new MySettingForm(['user_id' => $user->id]);

            $themes = Theme::find()
                ->orderBy(['id' => SORT_DESC])
                ->all();

            if ($model->load(App::post()) && $model->save()) {
                App::success('Settings Updated');
                return $this->redirect(['my-setting']);
            }

            return $this->render('my-setting', [
                'user' => $user,
                'model' => $model,
                'themes' => $themes,
            ]);
        }
    }

    public function actionGeneral($tab = 'system')
    {
        switch ($tab) {
            case 'system':
                $model = new SystemSettingForm();
                break;

            case 'email':
                $model = new EmailSettingForm();
                break;

            case 'image':
                $model = new ImageSettingForm();
                break;

            case 'notification':
                $model = new NotificationSettingForm();
                break;

            default:
                $model = new SystemSettingForm();
                break;
        }

        if ($model->load(App::post()) && $model->save()) {
            App::success('Successfully Changed');
            return $this->redirect(['general', 'tab' => $tab]);
        }

        return $this->render('general', [
            'model' => $model,
            'tab' => $tab,
        ]);
    }
}