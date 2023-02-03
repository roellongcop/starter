<?php

namespace app\controllers;

use app\helpers\App;
use app\models\Backup;
use app\models\File;
use app\models\Ip;
use app\models\Log;
use app\models\Notification;
use app\models\Queue;
use app\models\Role;
use app\models\Session;
use app\models\Setting;
use app\models\Theme;
use app\models\User;
use app\models\UserMeta;
use app\models\VisitLog;
use app\models\Visitor;
use app\models\search\DashboardSearch;

/**
 * DashboardController.
 */

class DashboardController extends Controller
{
    public function actionFindByKeywords($keywords='')
    {
        $data = array_merge(
            File::findByKeywords($keywords, ['name', 'extension', 'token']),
            Backup::findByKeywords($keywords, ['filename', 'tables', 'description']),
            Ip::findByKeywords($keywords, ['name', 'description']),
            Log::findByKeywords($keywords, ['method', 'action', 'controller', 'table_name', 'model_name']),
            Notification::findByKeywords($keywords, ['message']),
            Queue::findByKeywords($keywords, ['channel', 'job', 'pushed_at']),
            Role::findByKeywords($keywords, ['name']),
            Session::findByKeywords($keywords, ['id', 'expire', 'ip', 'browser', 'os', 'device']),
            Setting::findByKeywords($keywords, ['name', 'value']),
            Theme::findByKeywords($keywords, ['name', 'description']),
            User::findByKeywords($keywords, ['username', 'email']), 
            UserMeta::findByKeywords($keywords, ['name', 'value']), 
            VisitLog::findByKeywords($keywords, ['ip']), 
            Visitor::findByKeywords($keywords, ['expire', 'cookie', 'ip', 'browser', 'os', 'device', 'location'])
        );

        $data = array_unique($data);
        $data = array_values($data);
        sort($data);

        return $this->asJson($data);
    }

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

    public function actionInActiveData()
    {
        # dont delete; use in condition if user has access to in-active data
    }
}