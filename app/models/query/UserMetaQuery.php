<?php

namespace app\models\query;

/**
 * This is the ActiveQuery class for [[\app\models\UserMeta]].
 *
 * @see \app\models\UserMeta
 */
class UserMetaQuery extends ActiveQuery
{
    public function controllerID()
    {
        return 'user-meta';
    }
}
