<?php

namespace app\controllers;

use Yii;
use app\helpers\App;
use app\models\Ip;
use app\models\Log;
use app\models\search\IpSearch;
use app\widgets\ExportContent;
use yii\helpers\ArrayHelper;
use yii\helpers\Inflector;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;

/**
 * IpController implements the CRUD actions for Ip model.
 */
class IpController extends Controller
{
    /**
     * Lists all Ip models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new IpSearch();
        $dataProvider = $searchModel->search(['IpSearch' => App::queryParams()]);
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Ip model.
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
     * Creates a new Ip model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Ip();

        if ($model->load(App::post()) && $model->save()) {
            App::success('Successfully Created');

            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Ip model.
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
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Ip model.
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
     * Finds the Ip model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Ip the loaded model
     * @throws ForbiddenHttpException if the model cannot be found
     */
    protected function findModel($id, $field='id')
    {
        if (($model = IpSearch::one($id, $field)) != null) {
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

                $models = IpSearch::all($post['selection']);

                if (isset($post['confirm_button'])) {
                    switch ($post['process-selected']) {
                        case 'active':
                            Ip::updateAll(
                                ['record_status' => 1],
                                ['id' => $post['selection']]
                            );
                            break;
                        case 'in_active':
                            Ip::updateAll(
                                ['record_status' => 0],
                                ['id' => $post['selection']]
                            );
                            break;
                        case 'delete':
                            Ip::deleteAll(['id' => $post['selection']]);
                            break;
                        case 'white_list':
                            Ip::updateAll(
                                ['type' => 1],
                                ['id' => $post['selection']]
                            );
                            break;
                        case 'black_list':
                            Ip::updateAll(
                                ['type' => 0],
                                ['id' => $post['selection']]
                            );
                            break;
                        default:
                            # code...
                            break;
                    }
                    Log::record(new Ip(), ArrayHelper::map($models, 'id', 'attributes'));
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
            'searchModel' => new IpSearch(),
        ]);
    }
}
