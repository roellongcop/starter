<?php

namespace app\models\form\user;

use app\helpers\App;
use app\models\User;
use app\models\UserMeta;

abstract class UserForm extends \yii\base\Model
{
    public $user_id;

    protected $_user;
    protected $_meta;

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
        if (($user = $this->getUser()) == null) {
            $this->addError($attribute, 'User don\'t exist.');
        }
    }
    
    public function init()
    {
        parent::init();

        if (($meta = $this->getMeta()) != null) {
            $this->load([App::className($this) => json_decode($meta->value, true)]);
        }
    }

    public function getUser()
    {
        if ($this->_user === null) {
            $this->_user = User::findOne($this->user_id);
        }

        return $this->_user;
    }

    public function save()
    {
        if ($this->validate()) {
            $condition = [
                'user_id' => $this->user_id,
                'name' => static::META_NAME,
            ];
            $meta = UserMeta::findOne($condition);

            $meta = $meta ?: new UserMeta($condition);
            $meta->value = json_encode($this->attributes);

            if ($meta->save()) {
                return true;
            }
            else {
                $this->addError('meta', $meta->errors);
            }
        }

        return false;
    }

    public function getMeta()
    {
        if ($this->_meta === null) {
            $this->_meta = UserMeta::findOne([
                'user_id' => $this->user_id,
                'name' => static::META_NAME
            ]);
        }

        return $this->_meta;
    }
}