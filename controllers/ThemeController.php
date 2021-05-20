<?php

namespace app\controllers;

use Yii;
use app\helpers\App;
use app\models\File;
use app\models\Log;
use app\models\Theme;
use app\models\UserMeta;
use app\models\form\ThemeForm;
use app\models\search\ThemeSearch;
use app\widgets\ExportContent;
use yii\helpers\ArrayHelper;
use yii\helpers\Inflector;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;

/**
 * ThemeController implements the CRUD actions for Theme model.
 */
class ThemeController extends Controller 
{

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
            'model' => $this->findModel($slug, 'slug'),
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

            return $this->redirect(['view', 'slug' => $model->slug]);
        }

        return $this->render('create', [
            'model' => $model,
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
        $model = $this->findModel($slug, 'slug');

        if ($model->load(App::post()) && $model->save()) {
            $this->checkFileUpload($model);
            App::success('Successfully Updated');
            return $this->redirect(['view', 'slug' => $model->slug]);
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
     * Finds the Theme model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Theme the loaded model
     * @throws ForbiddenHttpException if the model cannot be found
     */
    protected function findModel($id, $field='id')
    {
        if (($model = Theme::findOne([$field => $id])) != null) {
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

                $models = Theme::all($post['selection']);

                if (isset($post['confirm_button'])) {
                    switch ($post['process-selected']) {
                        case 'active':
                            Theme::updateAll(
                                ['record_status' => 1],
                                ['id' => $post['selection']]
                            );
                            break;
                        case 'in_active':
                            Theme::updateAll(
                                ['record_status' => 0],
                                ['id' => $post['selection']]
                            );
                            break;
                        case 'delete':
                            Theme::deleteAll(['id' => $post['selection']]);
                            break;
                        default:
                            # code...
                            break;
                    }
                    Log::record(new Theme(), ArrayHelper::map($models, 'id', 'attributes'));
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
            'params'      => App::get(),
            'file'        => $file,
            'searchModel' => new ThemeSearch(),
        ]);
    }


    public function actionChangeImage()
    {
        if (App::post()) {
            $id = App::post('Theme')['id'] ?? 0;
            if (($model = Theme::findOne($id)) != null) {
                if ($model->load(App::post())) {
                    $model->imageInput = UploadedFile::getInstance($model, 'imageInput');
                    $model->upload();

                    return $model->imagePath . '&w=300';
                }
            }
        }
    }

    public function actionActivate($slug)
    {
        $theme = $this->findModel($slug, 'slug');
        $model = UserMeta::findOne([
            'user_id' => App::identity('id'),
            'meta_key' => 'theme'
        ]);

        $model = $model ?: new UserMeta([
            'user_id' => App::identity('id'),
            'meta_key' => 'theme'
        ]);

        $model->meta_value = $theme->id;
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
