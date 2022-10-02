<?php

namespace app\modules\api\v1\behaviors;

use yii\web\Response;

class ApiBehavior extends \yii\base\Behavior
{
    public function events()
    {
        return [
            Response::EVENT_BEFORE_SEND => 'beforeSend',
        ];
    } 

    public function beforeSend($event)
    {
        if ($event->sender->data !== null) {
            $event->sender->data = [
                'status' => $event->sender->isSuccessful,
                'data' => $event->sender->data,
            ];
            // $event->sender->statusCode = 200;
        }
    }
}