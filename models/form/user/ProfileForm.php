<?php

namespace app\models\form\user;

class ProfileForm extends UserForm
{
    const META_NAME = 'profile';

    public $first_name;
    public $last_name;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return $this->setRules([
            [['first_name', 'last_name',], 'required'],
            [['first_name', 'last_name',], 'string'],
        ]);
    }

    public function attributeLabels()
    {
        return [
            'first_name' => 'First Name',
            'last_name' => 'Last Name',
        ];
    }

    public function getDetailColumns()
    {
        return [
            'first_name:raw',
            'last_name:raw',
        ];
    }
}