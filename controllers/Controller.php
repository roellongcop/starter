<?php

namespace app\controllers;

use Yii;
use app\helpers\App;
use app\models\form\export\ExportCsvForm;
use app\models\form\export\ExportExcelForm;
use app\models\form\export\ExportPdfForm;
use app\widgets\ExportContent;

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

    public function exportPrint($searchModel)
    {
        return $this->render('/layouts/_print', [
            'content' => ExportContent::widget([
                'file' => 'pdf',
                'searchModel' => $searchModel,
            ])
        ]);
    }

    public function exportPdf($searchModel)
    {
        $model = new ExportPdfForm([
            'content' => ExportContent::widget([
                'file' => 'pdf',
                'searchModel' => $searchModel,
            ])
        ]);
        return $model->export();
    }

    public function exportCsv($searchModel)
    {
        $model = new ExportCsvForm([
            'content' => ExportContent::widget([
                'file' => 'excel',
                'searchModel' => $searchModel
            ]),
        ]);
        return $model->export();
    }

    public function exportXlsx($searchModel)
    {
        $model = new ExportExcelForm([
            'content' => ExportContent::widget([
                'file' => 'excel',
                'searchModel' => $searchModel
            ]), 
            'type' => 'xlsx'
        ]);
        return $model->export();
    }

    public function exportXls($searchModel)
    {
        $model = new ExportExcelForm([
            'content' => ExportContent::widget([
                'file' => 'excel',
                'searchModel' => $searchModel
            ]), 
            'type' => 'xls'
        ]);
        return $model->export();
    }

    public function changeRecordStatus($class='')
    {
        if (($post = App::post()) != null) {
            if (! $class) {
                $class = str_replace('Controller', '', App::className($this));
            }

            if (! str_contains($class, '\\')) { 
                $class = "app\\models\\{$class}";
            }

            $model = $class::controllerFind($post['id']);

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
}