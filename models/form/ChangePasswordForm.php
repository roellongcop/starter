<?php

namespace app\models\form;

use Yii;
use app\helpers\App;
use app\helpers\Url;
use app\jobs\EmailJob;
use app\jobs\NotificationJob;
use app\models\User;
use yii\base\Model;

/**
 * LoginForm is the model behind the login form.
 *
 * @property User|null $user This property is read-only.
 *
 */
class ChangePasswordForm extends Model
{
    public $user_id;
    public $old_password;
    public $new_password; 
    public $confirm_password; 
    public $password_hint; 

    public $_user; 

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // username and password are both required
            [['old_password', 'new_password', 'confirm_password', 'user_id', 'password_hint'], 'required'],
            ['old_password', 'validateOldPassword'],
            ['new_password', 'validateNewPassword'],
            ['confirm_password', 'compare', 'compareAttribute' => 'new_password'],
            ['user_id', 'validateUser'],
        ];
    }

    public function getUser()
    {
        if ($this->_user === NULL) {
            $this->_user = User::findOne($this->user_id);
        }

        return $this->_user;
    }

    public function validateUser($attribute, $params)
    {
        if (($user = $this->getUser()) == NULL) {
            $this->addError($attribute, 'User don\'t exist');
        }
    }

    public function validateOldPassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();
            if (!$user || !$user->validatePassword($this->old_password)) {
                $this->addError($attribute, 'Incorrect old password.');
            }
        }
    }

    public function validateNewPassword($attribute, $params)
    {
        if ($this->old_password == $this->new_password) {
            $this->addError($attribute, 'New password cannot be the same with old password.');
        }
    }

    public function changePassword()
    {
        if ($this->validate()) {
            $user = $this->getUser();

            $user->setPassword($this->new_password);
            $user->password_hint = $this->password_hint;

            if ($user->save()) {

                Yii::$app->queue->push(new NotificationJob([
                    'user_id' => $user->id,
                    'type' => 'notification_change_password',
                    'message' => App::generalSetting('notification_change_password'),
                    'link' => Url::to(['/user/my-password'], true),
                ]));

                Yii::$app->queue->push(new EmailJob([
                    'to' => $user->email,
                    'content' => App::generalSetting('email_change_password'),
                ]));

                return $user;
            }
        }

        return FALSE;
    }
}