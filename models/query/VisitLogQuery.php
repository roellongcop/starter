<?php

namespace app\models\query;

use app\models\VisitLog;

/**
 * This is the ActiveQuery class for [[\app\models\VisitLog]].
 *
 * @see \app\models\VisitLog
 */
class VisitLogQuery extends ActiveQuery
{
    public function login()
    {
        return $this->andWhere([
            $this->field('action') => VisitLog::ACTION_LOGIN
        ]); 
    }

    public function logout()
    {
        return $this->andWhere([
            $this->field('action') => VisitLog::ACTION_LOGOUT
        ]); 
    }
}