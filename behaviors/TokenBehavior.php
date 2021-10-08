<?php
namespace app\behaviors;

use app\helpers\App;
use yii\base\Behavior;
use yii\db\ActiveRecord;

class TokenBehavior extends Behavior
{
    public $tokenField = 'token';
    public $randomStringLength = 10;

    public function events()
    {
        return [
            ActiveRecord::EVENT_BEFORE_INSERT => 'beforeSave',
        ];
    }

    public function beforeSave($event)
    {
        if ($this->owner->hasProperty($this->tokenField)) {
            $this->owner->{$this->tokenField} = $this->owner->{$this->tokenField} ?: $this->generateToken($this->randomStringLength);
        }
    }


    protected function generateToken($length)
    {
        $token = App::randomString($length) . time();
        $model = $this->owner::findOne([$this->tokenField => $token]);

        if ($model) {
            return $this->generateToken($length);
        }

        return $token;
    }
}