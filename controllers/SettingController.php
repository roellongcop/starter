<?php

namespace app\controllers;

use Yii;
use app\helpers\App;
use app\models\Setting;
use app\models\Theme;
use app\models\form\SettingForm;
use app\models\form\setting\EmailSettingForm;
use app\models\form\setting\GeneralSettingForm;
use app\models\form\setting\ImageSettingForm;
use app\models\form\setting\NotificationSettingForm;
use app\models\form\setting\SystemSettingForm;
use app\models\form\user\MySettingForm;
use app\models\search\SettingSearch;
use app\widgets\ExportContent;
use yii\helpers\Html;
use yii\helpers\Inflector;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;

/**
 * SettingController implements the CRUD actions for Setting model.
 */
class SettingController extends Controller
{
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
            'model' => $this->findModel($name, 'name'),
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
        $model = $this->findModel($name, 'name');

        if ($model->load(App::post()) && $model->save()) {
            $this->checkFileUpload($model);
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
        $model = $this->findModel($name, 'name');

        if($model->delete()) {
            App::success('Successfully Deleted');
        }
        else {
            App::danger(json_encode($model->errors));
        }

        return $this->redirect(['index']);
    }

    /**
     * Finds the Setting model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Setting the loaded model
     * @throws ForbiddenHttpException if the model cannot be found
     */
    protected function findModel($id, $field='id')
    {
        if (($model = Setting::findVisible([$field => $id])) != null) {
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
                $model->refresh();
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

                $models = Setting::all($post['selection']);

                if (isset($post['confirm_button'])) {
                    switch ($post['process-selected']) {
                        case 'active':
                            Setting::activeAll(['id' => $post['selection']]);
                            break;
                        case 'in_active':
                            Setting::inactiveAll(['id' => $post['selection']]);
                            break;
                        case 'delete':
                            Setting::deleteAll(['id' => $post['selection']]);
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
            'searchModel' => new SettingSearch(),
        ]);
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

    public function actionGeneral($tab='system')
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

    public function actionInActiveData()
    {
        # dont delete; use in condition if user has access to in-active data
    }
}