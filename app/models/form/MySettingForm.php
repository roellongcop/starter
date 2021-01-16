<?php

namespace app\models\form;

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
class MySettingForm extends Model
{
    public $theme;
    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [
                [
                    'theme',
                ], 
                'required'
            ],

            [
                [
                    'theme',
                ], 
                'string'
            ],

        ];
    }

    public function init()
    {
        parent::init();
        $user_metas = UserMeta::find()
            ->where([
                'user_id' => App::identity('id'),
                'meta_key' => array_keys($this->attributes)
            ])
            ->all();
        foreach ($user_metas as $user_meta) {
            if (property_exists($this, $user_meta->meta_key)) {
                $this->{$user_meta->meta_key} = $user_meta->meta_value; 
            }
        }
    }

    public function save()
    {
        if ($this->validate()) {
            foreach ($this->attributes as $attribute => $value) {
                $user_meta = UserMeta::findOne([
                    'user_id' => App::identity('id'),
                    'meta_key' => $attribute
                ]);
                $user_meta = $user_meta ?: new UserMeta();
                $user_meta->user_id = App::identity('id');
                $user_meta->meta_key = $attribute;
                $user_meta->meta_value = $value;
                $user_meta->save();
            }

            return true;
        }
    }
 
}
