<?php

namespace app\controllers;

use Yii;
use app\helpers\App;
use app\models\Log;
use app\models\User;
use app\models\VisitLog;
use app\models\form\ChangePasswordForm;
use app\models\form\ProfileForm;
use app\models\search\UserSearch;
use app\widgets\ExportContent;
use yii\helpers\ArrayHelper;
use yii\helpers\Inflector;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;

/**
 * UserController implements the CRUD actions for User model.
 */
class UserController extends Controller
{
    /**
     * Lists all User models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search(['UserSearch' => App::queryParams()]);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single User model.
     * @param integer $slug
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
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new User();

        if ($model->load(App::post()) && $model->validate()) {
            $model->imageInput = UploadedFile::getInstance($model, 'imageInput');
            $model->setPassword($model->password);
            if ($model->save()) {
                $this->checkModelFile($model);
                $model->upload();
                App::success('Successfully Created');
                return $this->redirect(['view', 'slug' => $model->slug]);
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }


    /**
     * Duplicates an existing User model.
     * If duplication is successful, the browser will be redirected to the 'view' page.
     * @param integer $slug
     * @return mixed
     * @throws ForbiddenHttpException if the model cannot be found
     */
    public function actionDuplicate($slug)
    {
        $originalModel = $this->findModel($slug, 'slug');
        $model = new User();
        $model->attributes = $originalModel->attributes;


        if ($model->load(App::post()) && $model->validate()) {
            $model->setPassword($model->password);
            if ($model->save()) {
                $this->checkModelFile($model);
                App::success('Successfully Duplicated');
                return $this->redirect(['view', 'slug' => $model->slug]);
            }
        }

        return $this->render('duplicate', [
            'model' => $model,
            'originalModel' => $originalModel,
        ]);
    }

    /**
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $slug
     * @return mixed
     * @throws ForbiddenHttpException if the model cannot be found
     */
    public function actionUpdate($slug)
    {
        $model = $this->findModel($slug, 'slug'); 

        if ($model->load(App::post()) && $model->save()) {
            App::success('Successfully Updated');
            return $this->redirect(['view', 'slug' => $model->slug]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing User model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $slug
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

        return $this->redirect(['index']);
    }

    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return User the loaded model
     * @throws ForbiddenHttpException if the model cannot be found
     */
    protected function findModel($id, $field='id')
    {
        if (($model = User::findOne([$field => $id])) != null) {
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

                $models = User::all($post['selection']);

                if (isset($post['confirm_button'])) {
                    switch ($post['process-selected']) {
                        case 'active':
                            User::updateAll(
                                ['record_status' => 1],
                                ['id' => $post['selection']]
                            );
                            break;
                        case 'in_active':
                            User::updateAll(
                                ['record_status' => 0],
                                ['id' => $post['selection']]
                            );
                            break;
                        case 'delete':
                            User::deleteAll(['id' => $post['selection']]);
                            break;
                        case 'allowed':
                            User::updateAll(
                                ['is_blocked' => 0],
                                ['id' => $post['selection']]
                            );
                            break;
                        case 'blocked':
                            User::updateAll(
                                ['is_blocked' => 1],
                                ['id' => $post['selection']]
                            );
                            break;
                        default:
                            # code...
                            break;
                    }

                    Log::record(new User(), ArrayHelper::map($models, 'id', 'attributes'));
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
            'searchModel' => new UserSearch(),
        ]);
    }

    public function actionChangePassword($token='')
    {
        $user = $this->findModel($token, 'password_reset_token');
        $model = new ChangePasswordForm();

        if ($model->load(App::post()) && $model->validate()) {
            $user = $model->changePassword();
            App::success('Password Change.');
            return $this->redirect(['change-password', 'token' => $user->password_reset_token]);
        }
        return $this->render('change_password', [
            'model' => $model,
        ]);
    }

    public function actionProfile($slug)
    {
        $user = $this->findModel($slug, 'slug'); 
        $model = $user->profile;

        if ($model->load(App::post()) && $model->save()) {
            App::success('Profile Updated');
            return $this->redirect(['profile', 'slug' => $user->slug]);
        }

        return $this->render('profile', [
            'user' => $user,
            'model' => $model,
        ]);
    }

    public function actionMyAccount()
    {
        $model = App::identity();

        if ($model->load(App::post()) && $model->validate()) {
            $model->imageInput = UploadedFile::getInstance($model, 'imageInput');
            if ($model->save()) {
                $model->upload();
                App::success('Successfully Updated');
                return $this->refresh();
            }
        } 

        return $this->render('my_account', [
            'model' => $model,
        ]);
    }


    public function actionDashboard($slug)
    {
        $model = User::find()
            ->where([
                'slug' => $slug,
                'status' => 10,
                'is_blocked' => 0,
                'record_status' => 1
            ])
            ->one();

        if ($model) {
            VisitLog::logout();
            App::user()->logout();

            App::user()->login($model, 0);
            VisitLog::login();

            return $this->redirect(['dashboard/index']);
        }
        else {
            App::danger('No user found or user is cannot be log in.');
        }

        return $this->redirect(App::referrer());
    }

    public function actionInActiveData()
    {
        # dont delete; use in condition if user has access to in-active data
    }
}
