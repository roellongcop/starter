<?php

namespace app\jobs;

use app\models\Notification;

class NotificationJob extends \yii\base\BaseObject implements \yii\queue\JobInterface
{
    public $user_id;
    public $type;
    public $link;
    public $message;

    public function execute($queue)
    {
        $notification = new Notification([
            'status' => Notification::STATUS_UNREAD,
            'record_status' => 1,
            'user_id' => $this->user_id,
            'type' => $this->type,
            'link' => $this->link,
            'message' => $this->message,
        ]);

        return $notification->save();
    }
}