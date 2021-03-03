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
class ProfileForm extends \app\models\User
{
    public $first_name;
    public $last_name;
    public $company_id;

    public function attributeLabels()
    {
        return [
            'first_name' => 'First Name',
            'last_name' => 'Last Name',
            'company_id' => 'Company',
        ];
    }

    
    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [
                [
                    'first_name',
                    'last_name',
                ], 
                'required'
            ],

            [
                [
                    'company_id',
                ], 
                'integer'
            ],

            [
                [
                    'first_name',
                    'last_name',
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
                'user_id' => $this->id,
                'meta_key' => array_keys(self::attributeLabels())
            ])
            ->all();
        foreach ($user_metas as $user_meta) {
            if ($this->hasProperty($user_meta->meta_key)) {
                $this->{$user_meta->meta_key} = $user_meta->meta_value; 
            }
        }
    }

    public function save($runValidation = true, $attributeNames = NULL)
    {
        if ($this->validate()) {
            foreach ($this->getAttributes(array_keys(self::attributeLabels())) as $attribute => $value) {
                $user_meta = UserMeta::findOne([
                    'user_id' => $this->id,
                    'meta_key' => $attribute
                ]);
                $user_meta = $user_meta ?: new UserMeta();
                $user_meta->user_id = $this->id;
                $user_meta->meta_key = $attribute;
                $user_meta->meta_value = $value;
                if (! $user_meta->save()) {
                    App::danger($user_meta->errors);
                }
            }

            return true;
        }
    }
 
}
