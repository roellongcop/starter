<?php

namespace app\models\form;

use app\models\User;
use app\models\form\CustomEmailForm;

class PasswordResetForm extends \yii\base\Model
{
    public $email;
    public $hint = false;

    public $_user;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // username and password are both required
            ['email', 'required'],
            ['email', 'trim'],
            ['email', 'email'],
            ['email', 'exist', 'targetClass' => 'app\models\User', 'targetAttribute' => 'email'],
            ['email', 'validateEmail'],
            ['hint', 'safe'],
        ];
    }

    public function validateEmail($attribute, $params)
    {
        if (($user = $this->getUser()) != null) {
            if ($user->is_blocked == User::BLOCKED) {
                $this->addError($attribute, 'User is blocked.');
            }

            if ($user->status == User::STATUS_DELETED) {
                $this->addError($attribute, 'User is deleted.');
            }

            if ($user->status == User::STATUS_INACTIVE) {
                $this->addError($attribute, 'User is inactive.');
            }

            if ($user->record_status == User::RECORD_INACTIVE) {
                $this->addError($attribute, 'User record is inactive.');
            }
        }
    }

    public function getUser()
    {
        if ($this->_user == null) {
            $this->_user = User::findByEmail($this->email);
        }

        return $this->_user;
    }

    public function process()
    {
        if ($this->validate()) {
            $user = $this->getUser();
            if ($this->hint) {
                return $user;
            }

            $mail = new CustomEmailForm([
                'template' => 'password_reset',
                'parameters' => ['user' => $user],
                'to' => $this->email
            ]);
            if ($mail->send()) {
                return $user;
            }
        }

        return false;
    }
}