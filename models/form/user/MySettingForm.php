<?php

namespace app\models\form\user;

use Yii;
use app\helpers\App;
use app\models\UserMeta;
use yii\base\Model;

/**
 * LoginForm is the model behind the login form.
 *
 * @property User|null $user This property is read-only.
 *
 */
class MySettingForm extends \app\models\User
{
    public $theme;
    
    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['theme', ], 'required'],

            [['theme', ], 'string'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'theme' => 'Theme',
        ];
    }

    public function init()
    {
        parent::init();

        $user_metas = UserMeta::find()
            ->where([
                'user_id' => $this->id,
                'name' => array_keys(self::attributeLabels())
            ])
            ->all();
        foreach ($user_metas as $user_meta) {
            if ($this->hasProperty($user_meta->name)) {
                $this->{$user_meta->name} = $user_meta->value; 
            }
        }
    }

    public function save($runValidation = true, $attributeNames = NULL)
    {
        if ($this->validate()) {
            foreach ($this->getAttributes(array_keys(self::attributeLabels())) as $attribute => $value) {
                $user_meta = UserMeta::findOne([
                    'user_id' => $this->id,
                    'name' => $attribute
                ]);
                $user_meta = $user_meta ?: new UserMeta();
                $user_meta->user_id = $this->id;
                $user_meta->name = $attribute;
                $user_meta->value = $value;
                if (! $user_meta->save()) {
                    App::danger($user_meta->errors);
                }
            }

            return true;
        }
    }
}