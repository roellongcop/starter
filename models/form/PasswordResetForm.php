<?php

namespace app\models\form;

use Yii;
use app\helpers\App;
use app\models\User;
use app\models\form\CustomEmailForm;
use yii\base\Model;

/**
 * LoginForm is the model behind the login form.
 *
 * @property User|null $user This property is read-only.
 *
 */
class PasswordResetForm extends Model
{
    public $email; 
    public $hint = false; 

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // username and password are both required
            [['email'], 'required'],
            [['email'], 'email'],
            ['hint', 'safe'],
        ];
    } 

    public function process()
    {
        if ($this->validate()) {
            $user = User::find()
                ->where([
                    'email' => $this->email,
                    'is_blocked' => 0,
                    'status' => 10, //active
                ])
                ->one();

            if ($user) {
                if ($this->hint) {
                    App::success("Your password hint is: '{$user->password_hint}'.");
                    return true;
                }
                else {
                    $mail = new CustomEmailForm();
                    $mail->content = 'test';
                    $mail->to = $user->email;
                    if ($mail->send()) {
                        App::success("Email sent.");
                        return true;
                    }
                    else {
                        App::danger("Email not sent.");
                    }
                }
            }
            else {
                App::warning("User not exist or Blocked.");
            }
        }
        else {
            App::danger($this->errors);
        }

        return false;
    }
}