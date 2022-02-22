<?php

namespace app\models\form\user;

use Yii;
use app\models\User;

abstract class UserForm extends \yii\base\Model
{
    public $user_id;

    protected $_user;

    public function setRules($rules)
    {
        return array_merge($rules, [
            'required' => ['user_id', 'required'],
            'integer' => ['user_id', 'integer'],
            'validateUserId' => ['user_id', 'validateUserId'],
        ]);
    }

    public function validateUserId($attribute, $params)
    {
        if (($user = $this->getUser()) == NULL) {
            $this->addError($attribute, 'User don\'t exist.');
        }
    }
    
    public function init()
    {
        parent::init();

        if (($user = $this->getUser()) != NULL) {
            if (($meta = $user->meta(static::META_NAME)) != NULL) {
                $this->load([
                    (new \ReflectionClass($this))->getShortName() => json_decode($meta, true)
                ]);
            }
        }
    }

    public function getUser()
    {
        if ($this->_user === NULL) {
            $this->_user = User::findOne($this->user_id);
        }

        return $this->_user;
    }

    public function save()
    {
        if ($this->validate()) {
            if (($user = $this->getUser()) != NULL) {
                $user->saveMeta([static::META_NAME => $this->attributes]);
                return true;
            }
        }

        return false;
    }
}