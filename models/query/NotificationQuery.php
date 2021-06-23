<?php

namespace app\models\query;

use app\models\Notification;

/**
 * This is the ActiveQuery class for [[\app\models\Notification]].
 *
 * @see \app\models\Notification
 */
class NotificationQuery extends ActiveQuery
{
    public function unread()
    {
        return $this->andWhere([
            $this->field('status') => Notification::STATUS_UNREAD
        ]);
    }

    public function read()
    {
        return $this->andWhere([
            $this->field('status') => Notification::STATUS_READ
        ]);
    }
}