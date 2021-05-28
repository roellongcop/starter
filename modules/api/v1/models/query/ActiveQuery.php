<?php

namespace app\modules\api\v1\models\query;


class ActiveQuery extends \yii\db\ActiveQuery
{
    public function _getAlias()
    {
        if ($this->from && is_array($this->from)) {
            $alias = array_keys($this->from)[0] ?? '';

            return $alias;
        }
    }
    public function field($field)
    {
        if (($alias = $this->_getAlias()) != null) {
            return "{$alias}.{$field}";
        }
        return $field;
    }

    public function active($alias='')
    {
        if ($alias) {
            $alias = is_array($alias)? $alias: [$alias];

            $condition = [];

            foreach ($alias as $a) {
                $condition["{$a}.record_status"] = 1;
            }

            return $this->andWhere($condition);
        }

        return $this->andWhere([
            $this->field('record_status') => 1
        ]);
    }

    public function inActive($alias='')
    {
        if ($alias) {
            $alias = is_array($alias)? $alias: [$alias];
            
            $condition = [];

            foreach ($alias as $a) {
                $condition["{$a}.record_status"] = 0;
            }

            return $this->andWhere($condition);
        }

        return $this->andWhere([
            $this->field('record_status') => 0
        ]);
    }


    public function all($db = null)
    {
        return parent::all($db);
    }

    public function one($db = null)
    {
        return parent::one($db);
    }
}
