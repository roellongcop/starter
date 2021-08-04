<?php

namespace app\models\form\user;

use Yii;
use app\helpers\App;
use app\models\Theme;
use app\models\User;
use app\models\UserMeta;

/**
 * LoginForm is the model behind the login form.
 *
 * @property User|null $user This property is read-only.
 *
 */
class MySettingForm extends \yii\base\Model
{
    const META_NAME = 'my-settings';
    private $_user;
    private $_theme;

    public $theme_id;
    public $user_id;
    
    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['theme_id', 'user_id'], 'required'],
            [['user_id', 'theme_id'], 'integer'],
            [['user_id'], 'validateUserId'],
            [['theme_id'], 'validateThemeId'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'theme_id' => 'Theme',
            'user_id' => 'User ID',
        ];
    }

    public function init()
    {
        parent::init();

        if (($user = $this->getUser()) != NULL) {

            if (($meta = $user->meta(self::META_NAME)) != NULL) {
                $this->load([App::className($this) => json_decode($meta, true)]);
            }
        }
    }

    public function validateThemeId($attribute, $params)
    {
        if (($theme = $this->getTheme()) == NULL) {
            $this->addError($attribute, 'Theme don\'t exist.');
        }
    }

    public function validateUserId($attribute, $params)
    {
        if (($user = $this->getUser()) == NULL) {
            $this->addError($attribute, 'User don\'t exist.');
        }
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

    public function getUser()
    {
        if ($this->_user === NULL) {
            $this->_user = User::findOne($this->user_id);
        }

        return $this->_user;
    }

    public function getTheme()
    {
        if ($this->_theme === NULL) {
            $this->_theme = Theme::findOne($this->theme_id);
        }
        return $this->_theme;
    }
}