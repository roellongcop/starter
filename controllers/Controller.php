<?php

namespace app\controllers;

use Yii;
use app\helpers\App;
use app\models\form\export\ExportCsvForm;
use app\models\form\export\ExportExcelForm;
use app\models\form\export\ExportPdfForm;
use app\widgets\ExportContent;
use yii\helpers\Inflector;
use app\helpers\Html;
use app\widgets\ActiveForm;

/**
 * RoleController implements the CRUD actions for Role model.
 */
abstract class Controller extends \yii\web\Controller
{
    public function beforeAction($action)
    {
        if (!parent::beforeAction($action)) {
            return false;
        }

        App::view()->params['activeMenuLink'] = "/{$this->owner->id}";
        
        switch ($action->id) {
            case 'print':
                $this->layout = 'print';
                break;
            
            default:
                // code...
                break;
        }

        return true;
    }

    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['ThemeFilter'] = ['class' => 'app\filters\ThemeFilter'];
        $behaviors['UserFilter'] = ['class' => 'app\filters\UserFilter'];
        $behaviors['IpFilter'] = ['class' => 'app\filters\IpFilter'];
        $behaviors['VerbFilter'] = ['class' => 'app\filters\VerbFilter'];
        $behaviors['AccessControl'] = ['class' => 'app\filters\AccessControl'];

        if (App::setting('system')->enable_visitor) {
            $behaviors['VisitorFilter'] = [
                'class' => 'app\filters\VisitorFilter'
            ];
        }

        return $behaviors;
    }

    public function exportPrint($searchModel='')
    {
        $searchModel = $searchModel ?: $this->searchModelObject();
        return $this->render('/layouts/_print', [
            'content' => ExportContent::widget([
                'file' => 'pdf',
                'searchModel' => $searchModel,
            ])
        ]);
    }

    public function exportPdf($searchModel='')
    {
        $searchModel = $searchModel ?: $this->searchModelObject();
        $model = new ExportPdfForm([
            'content' => ExportContent::widget([
                'file' => 'pdf',
                'searchModel' => $searchModel,
            ])
        ]);
        return $model->export();
    }

    public function exportCsv($searchModel='')
    {
        $searchModel = $searchModel ?: $this->searchModelObject();
        $model = new ExportCsvForm([
            'content' => ExportContent::widget([
                'file' => 'excel',
                'searchModel' => $searchModel
            ]),
        ]);
        return $model->export();
    }

    public function exportXlsx($searchModel='')
    {
        $searchModel = $searchModel ?: $this->searchModelObject();
        $model = new ExportExcelForm([
            'content' => ExportContent::widget([
                'file' => 'excel',
                'searchModel' => $searchModel
            ]), 
            'type' => 'xlsx'
        ]);
        return $model->export();
    }

    public function exportXls($searchModel='')
    {
        $searchModel = $searchModel ?: $this->searchModelObject();
        $model = new ExportExcelForm([
            'content' => ExportContent::widget([
                'file' => 'excel',
                'searchModel' => $searchModel
            ]), 
            'type' => 'xls'
        ]);
        return $model->export();
    }

    protected function modelObject()
    {
        $class = substr(App::className($this), 0, -10);
        return Yii::createObject("app\\models\\{$class}");
    }

    protected function searchModelObject()
    {
        $class = substr(App::className($this), 0, -10);
        return Yii::createObject("app\\models\\search\\{$class}Search");
    }

    public function changeRecordStatus($function='')
    {
        if (($post = App::post()) != null) {

            if (! $function) {
                $obj = $this->modelObject();
                $model = $obj::controllerFind($post['id']);
            }
            else {
                $model = call_user_func($function, $post['id']);
            }

            if (!$model) {
                return $this->asJson([
                    'status' => 'failed',
                    'errors' => 'No data found.',
                    'errorSummary' => 'No data found.'
                ]);
            }

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

    public function actionFindByKeywords($keywords='')
    {
        $data = [];

        return $this->asJson($data);
    }

    public function bulkAction($model='')
    {
        $model = $model ?: $this->modelObject();

        $post = App::post();

        if (isset($post['process-selected'])) {
            $process = Inflector::humanize($post['process-selected']);
            if (isset($post['selection'])) {

                $models = $model::all($post['selection']);

                if (isset($post['confirm_button'])) {
                    foreach ($model->bulkActions as $postAction => $action) {
                        if ($postAction == $post['process-selected']) {
                            call_user_func($action['function'], $post['selection']);
                        }
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

    public function _ajaxCreated($model)
    {
        $model->refresh();
        $response['status'] = 'success';
        $response['model'] = $model;

        return $this->asJson($response);
    }

    public function _ajaxValidate($model)
    {
        if ($model->load(App::post())) {
            return $this->asJson(ActiveForm::validate($model));
        }
    }

    public function _ajaxForm($model, $template='_form-ajax')
    {
        $response['status'] = ($model->errors)? 'failed': 'success';
        $response['errors'] = $model->errors;
        $response['errorSummary'] = Html::errorSummary($model);
        $response['model'] = $model;
        $response['form'] = $this->renderAjax($template, [
            'model' => $model
        ]);

        return $this->asJson($response);
    }
}