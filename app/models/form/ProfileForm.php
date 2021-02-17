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
class ProfileForm extends Model
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
            [
            	[
                    'user_id',
            		'first_name',
				    'last_name',
            	], 
	            'required'
	        ],

	        [
            	[
            		'first_name',
                    'last_name',
            	], 
	            'string'
	        ],

            [['user_id'], 'integer'],
 
        ];
    }

    public function setup()
    {
        $user_metas = UserMeta::find()
            ->where([
                'user_id' => $this->user_id,
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
                    'user_id' => $this->user_id,
                    'meta_key' => $attribute
                ]);
                $user_meta = $user_meta ?: new UserMeta();
                $user_meta->user_id = $this->user_id;
                $user_meta->meta_key = $attribute;
                $user_meta->meta_value = $value;
                $user_meta->save();
            }

            return true;
        }
    }
 
}
