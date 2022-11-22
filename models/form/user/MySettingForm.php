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
class MySettingForm extends UserForm
{
    const META_NAME = 'my-settings';
    
    public $theme_id;

    private $_theme;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return $this->setRules([
            [['theme_id'], 'required'],
            [['theme_id'], 'integer'],
            [['theme_id'], 'validateThemeId'],
        ]);
    }

    public function attributeLabels()
    {
        return [
            'theme_id' => 'Theme',
            'user_id' => 'User ID',
        ];
    }

    public function validateThemeId($attribute, $params)
    {
        if (($theme = $this->getTheme()) == null) {
            $this->addError($attribute, 'Theme don\'t exist.');
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

    public function getTheme()
    {
        if ($this->_theme === null) {
            $this->_theme = Theme::findOne($this->theme_id);
        }
        return $this->_theme;
    }
}