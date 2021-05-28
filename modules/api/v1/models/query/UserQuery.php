<?php

namespace app\modules\api\v1\models\query;

/**
 * This is the ActiveQuery class for [[User]].
 *
 * @see User
 */
class UserQuery extends ActiveQuery
{
    public function available()
    {
        return $this->andWhere([
            $this->field('record_status') => 1,
            $this->field('status') => 10,
            $this->field('is_blocked') => 0,
        ]);
    }
}
