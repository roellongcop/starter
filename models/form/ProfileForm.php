<?php

namespace app\models\form;

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
    public $user_id;
    public $first_name;
    public $last_name;
    
    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['first_name', 'last_name', ], 'required'],
            [['user_id'], 'safe'],
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

        $profile = $this->user->meta('profile');

        if ($profile) {
            $profileAttributes = json_decode($profile, true);

            foreach ($profileAttributes as $key => $value) {
                if ($this->hasProperty($key)) {
                    $this->{$key} = $value; 
                }
            }
        }
    }

    public function getUser()
    {
        return User::findOne($this->user_id);
    }

    public function save()
    {
        $user = $this->user;
        
        if ($this->validate()) {
            $profile = $user->meta('profile');
           
            $profile = $profile ?: new UserMeta();
            $user->saveMeta(['profile' => $this->attributes]);

            return true;
        }
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
