<?php

namespace app\models\query;

/**
 * This is the ActiveQuery class for [[\app\models\Setting]].
 *
 * @see \app\models\Setting
 */
class SettingQuery extends ActiveQuery
{
    public function general($alias='')
    {
    	$field = ($alias)? "{$alias}.type": 'type';

    	return $this->andWhere([
            $field => 'general'
        ]);
    }
}