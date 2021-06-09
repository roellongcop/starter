<?php
namespace app\models\query;

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
            $this->field('record_status') => 1,
            $this->field('status') => 10,
            $this->field('is_blocked') => 0,
        ]);
    }
}