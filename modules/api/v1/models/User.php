<?php

namespace app\modules\api\v1\models;

use Yii;

class User extends \app\models\User
{
    public function fields()
    {
        $fields = parent::fields();

        // remove fields that contain sensitive information
        unset(
            $fields['auth_key'], 
            $fields['password_hash'], 
            $fields['password_reset_token'],
            $fields['password_hint'],
        );

        return $fields;
    }
}