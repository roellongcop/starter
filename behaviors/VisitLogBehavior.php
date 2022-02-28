<?php

namespace app\behaviors;

use app\helpers\App;
use app\models\VisitLog;
use yii\web\User;

class VisitLogBehavior extends \yii\base\Behavior
{
    public function events()
    {
        return [
            User::EVENT_AFTER_LOGIN => 'insertLoginLog',
            User::EVENT_AFTER_LOGOUT => 'insertLogoutLog',
        ];
    }

    public function insertLoginLog($event)
    {
        $identity = $event->identity;
        $this->log($identity, VisitLog::ACTION_LOGIN);
    }

    public function insertLogoutLog($event)
    {
        $identity = $event->identity;
        $this->log($identity, VisitLog::ACTION_LOGOUT);
    }

    public function log($identity, $action)
    {
        $visit = new VisitLog();
        $visit->user_id = $identity->id;
        $visit->ip = App::ip();
        $visit->action = $action;
        return $visit->save();
    }
}