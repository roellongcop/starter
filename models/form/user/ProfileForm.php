<?php

namespace app\models\form\user;

use Yii;
use app\helpers\App;
use app\models\User;
use app\models\UserMeta;

/**
 * LoginForm is the model behind the login form.
 *
 * @property User|null $user This property is read-only.
 *
 */
class ProfileForm extends \yii\base\Model
{
    const META_NAME = 'profile';

    public $user_id;
    public $first_name;
    public $last_name;

    private $_user;
    
    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['first_name', 'last_name', 'user_id'], 'required'],
            [['user_id'], 'integer'],
            [['user_id'], 'validateUserId'],
            [['first_name', 'last_name', ], 'string'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'first_name' => 'First Name',
            'last_name' => 'Last Name',
            'user_id' => 'User ID',
        ];
    }

    public function init()
    {
        parent::init();

        if (($user = $this->getUser()) != NULL) {
            if (($meta = $user->meta(self::META_NAME)) != NULL) {
                $this->load(['ProfileForm' => json_decode($meta, true)]);
            }
        }
    }

    public function validateUserId($attribute, $params)
    {
        if (($user = $this->getUser()) == NULL) {
            $this->addError($attribute, 'User don\'t exist.');
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
                $user->saveMeta([self::META_NAME => $this->attributes]);
                return TRUE;
            }
        }

        return FALSE;
    }

    public function getDetailColumns()
    {
        return [
            'user_id:raw',
            'first_name:raw',
            'last_name:raw',
        ];
    }
}