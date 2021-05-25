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
    public $old_password; 
    public $new_password; 
    public $confirm_password; 
    public $password_hint; 

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // username and password are both required
            [['old_password', 'new_password', 'confirm_password', 'password_hint'], 'required'],
            [['old_password'], 'validateOldPassword'],
            [['confirm_password'], 'validatePassword'],
        ];
    } 


    public function validateOldPassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = App::identity();
            if (!$user || !$user->validatePassword($this->old_password)) {
                $this->addError($attribute, 'Incorrect old password.');
            }
        }
    }

    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            if ($this->new_password != $this->confirm_password) {
                $this->addError($attribute, 'password dont matched.');
            }
        }
    }

    public function changePassword()
    {
        $user = App::identity();

        $user->setPassword($this->new_password);
        $user->password_hint = $this->password_hint;
        if ($user->save()) {
            $message = App::setting('notification_change_password');

            Yii::$app->queue->push(new NotificationJob([
                'user_id' => $user->id,
                'type' => 'notification_change_password',
                'message' => $message,
                'link' => Url::to(['user/my-password'], true),
            ]));

            Yii::$app->queue->push(new EmailJob([
                'to' => $user->email,
                'content' => $message,
            ]));

            return $user;
        }
        else {
            App::danger($user->errors);
        }
    }
}
