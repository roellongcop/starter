<?php

namespace app\controllers;

use Yii;
use app\helpers\App;
use app\models\search\DashboardSearch;
/**
 * BackupController implements the CRUD actions for Backup model.
 */
class DashboardController extends Controller
{
    /**
     * Lists all Backup models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new DashboardSearch();

        if (($queryParams = App::queryParams()) != null) {
            $dataProviders = $searchModel->search(['DashboardSearch' => $queryParams]);

            if ($searchModel->keywords) {
                return $this->render('search_result', [
                    'dataProviders' => $dataProviders,
                    'searchModel' => $searchModel,
                ]);
            }
            else {
                return $this->redirect(['index']);
            }
           
        }


        return $this->render('index', [
            'searchModel' => $searchModel
        ]);
    }
}
