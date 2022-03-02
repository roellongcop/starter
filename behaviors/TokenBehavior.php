<?php

namespace app\behaviors;

use app\helpers\App;
use yii\db\ActiveRecord;

class TokenBehavior extends \yii\base\Behavior
{
    public $tokenField = 'token';
    public $tokenValue;

    public function events()
    {
        return [
            ActiveRecord::EVENT_BEFORE_INSERT => 'beforeSave',
        ];
    }

    public function beforeSave($event)
    {
        if ($this->owner->hasProperty($this->tokenField)) {
            if ($this->tokenValue && is_callable($this->tokenValue)) {
                $this->owner->{$this->tokenField} = call_user_func($this->tokenValue, $this->owner);
            }
            else {
                $this->owner->{$this->tokenField} = $this->generateToken();
            }
        }
    }

    protected function generateToken($length = 10)
    {
        $token = implode('-', [
            App::randomString($length),
            time()
        ]);
        $model = $this->owner::findOne([$this->tokenField => $token]);

        if ($model) {
            return $this->generateToken($length);
        }

        return $token;
    }
}