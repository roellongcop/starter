<?php
namespace app\components;

use Yii;
use app\helpers\App; 
use yii\base\Component; 
use app\models\Log;
use app\models\VisitLog;

/**
 * 
 */
class LogBookComponent extends Component
{
    public function visitLog($action=0)
    {
        $visit = new VisitLog();
        $visit->user_id = App::identity('id');
        $visit->ip = App::ip();
        $visit->action = $action; // login | logout
        return $visit->save();
    }


    public function log($model, $changedAttributes=[])
    {
        if (App::isLogin()) {
            $log                   = new Log();
            $log->request_data     = App::getBodyParams();
            $log->method           = App::getMethod();
            $log->url              = App::absoluteUrl();
            $log->user_id          = App::identity('id');
            $log->model_id         = $model->id ?: 0;
            $log->action           = App::actionID();
            $log->controller       = App::controllerID();
            $log->table_name       = App::tableName($model, false);
            $log->model_name       = App::getModelName($model);
            $log->user_agent       = App::userAgent();
            $log->ip               = App::ip();
            $log->browser          = App::browser();
            $log->os               = App::os();
            $log->device           = App::device();
            $log->change_attribute = $changedAttributes;

            return $log->save();
        }
    } 
}