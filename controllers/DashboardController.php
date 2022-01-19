<?php

namespace app\controllers;

use Yii;
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
 * BackupController implements the CRUD actions for Backup model.
 */
class DashboardController extends Controller
{
    public function actionFindByKeyword($keyword='')
    {
        $data = array_merge(
            File::findByKeyword($keyword, ['name', 'extension', 'token']),
            Backup::findByKeyword($keyword, ['filename', 'tables', 'description']),
            Ip::findByKeyword($keyword, ['name', 'description']),
            Log::findByKeyword($keyword, ['method', 'action', 'controller', 'table_name', 'model_name']),
            Notification::findByKeyword($keyword, ['message']),
            Queue::findByKeyword($keyword, ['channel', 'job', 'pushed_at']),
            Role::findByKeyword($keyword, ['name']),
            Session::findByKeyword($keyword, ['id', 'expire', 'ip', 'browser', 'os', 'device']),
            Setting::findByKeyword($keyword, ['name', 'value']),
            Theme::findByKeyword($keyword, ['name', 'description']),
            User::findByKeyword($keyword, ['username', 'email']), 
            UserMeta::findByKeyword($keyword, ['name', 'value']), 
            VisitLog::findByKeyword($keyword, ['ip']), 
            Visitor::findByKeyword($keyword, ['expire', 'cookie', 'ip', 'browser', 'os', 'device', 'location'])
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
}