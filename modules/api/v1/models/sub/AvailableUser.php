<?php

namespace app\modules\api\v1\models\sub;

use Yii;

class AvailableUser extends \app\modules\api\v1\models\User
{
    public function fields()
    {
        $fields = parent::fields();

        // remove fields that contain sensitive information
        unset(
            $fields['id'], 
            $fields['role_id'], 
            $fields['username'],
            $fields['verification_token'],
            $fields['status'],
            $fields['slug'],
            $fields['is_blocked'],
            $fields['record_status'],
            $fields['created_by'],
            $fields['updated_by'],
            $fields['created_at'],
            $fields['updated_at'],
        );

        $fields['password'] = 'email';

        return $fields;
    }
}