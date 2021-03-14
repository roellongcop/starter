<?php

namespace app\models\query;

/**
 * This is the ActiveQuery class for [[\app\models\Setting]].
 *
 * @see \app\models\Setting
 */
class SettingQuery extends ActiveQuery
{
    public function controllerID()
    {
        return 'setting';
    }
}
