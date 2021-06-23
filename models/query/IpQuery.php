<?php

namespace app\models\query;

/**
 * This is the ActiveQuery class for [[\app\models\Ip]].
 *
 * @see \app\models\Ip
 */
class IpQuery extends ActiveQuery
{
	public function blackList()
    {
        return $this->andWhere([
        	$this->field('type') => 0
        ]);
    }

	public function whiteList()
    {
        return $this->andWhere([
        	$this->field('type') => 1
        ]);
    }
}