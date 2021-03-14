<?php

namespace app\models\query;

/**
 * This is the ActiveQuery class for [[\app\models\User]].
 *
 * @see \app\models\User
 */
class UserQuery extends ActiveQuery
{
    public function controllerID()
    {
        return 'user';
    }
}
