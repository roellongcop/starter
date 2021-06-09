<?php
namespace app\controllers;

use Yii;
use app\helpers\App;
use app\models\UserMeta;
use app\models\search\UserMetaSearch;
use app\widgets\ExportContent;
use yii\helpers\Inflector;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;

/**
 * UserMetaController implements the CRUD actions for UserMeta model.
 */
class UserMetaController extends Controller
{
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

        return $this->redirect(['index']);
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
        if (($model = UserMeta::findOne([$field => $id])) != null) {
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

    public function actionConfirmAction()
    {
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
            'searchModel' => new UserMetaSearch(),
        ]);
    }

    public function actionFilter()
    {
        if (($post = App::post()) != null) {
            $model = UserMeta::findOne([
                'user_id' => App::identity('id'),
                'meta_key' => 'table_columns',
            ]);

            $model = $model ?: new UserMeta();

            if ($model->isNewRecord) {
                $model->user_id = App::identity('id');
                $model->meta_key = 'table_columns';
            }
            else {
                $table_columns = json_decode($model->meta_value, true);
            }
            $table_columns[$post['UserMeta']['table_name']] = $post['UserMeta']['columns'] ?? [];
            $model->meta_value = json_encode($table_columns);
            $model->save();
        }
        return $this->redirect(App::referrer());
    }

    public function actionInActiveData()
    {
        # dont delete; use in condition if user has access to in-active data
    }
}