<?php

namespace app\models\query;

use app\models\ActiveRecord;
use app\models\User;

/**
 * This is the ActiveQuery class for [[\app\models\User]].
 *
 * @see \app\models\User
 */
class UserQuery extends ActiveQuery
{
    public function available()
    {
        return $this->andWhere([
            $this->field('record_status') => ActiveRecord::RECORD_ACTIVE,
            $this->field('status') => User::STATUS_ACTIVE,
            $this->field('is_blocked') => User::UNBLOCKED,
        ]);
    }
}