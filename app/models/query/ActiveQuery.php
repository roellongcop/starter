<?php
namespace app\models\query;

use app\helpers\App;

abstract class ActiveQuery extends \yii\db\ActiveQuery
{
    abstract public function controllerID();

    public function daterange($daterange='', $field='created_at')
    {
        if ($daterange) {
            $field = $this->field($field);
            
            $hours = App::formatter()->asDateToTimezone(date("Y-m-d H:i:s"), "P");

            return $this->andFilterWhere([
                "between", 
                "date(DATE_ADD({$field},INTERVAL '{$hours}' HOUR_MINUTE))", 
                App::dateRange($daterange, 'start'), 
                App::dateRange($daterange, 'end'), 
            ]);
        }

        return $this;
    }

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

    public function visible($alias = '')
    {
        $field = $this->field('record_status');


        $condition[$field] = 1;

        if (App::isLogin()) {
            if (App::identity()->can('in-active-data', $this->controllerID())) {
                $condition[$field] = '';
            }
        }

        return $this->andFilterWhere($condition);
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

    public function count($q = '*', $db = NULL)
    {
        $this->visible();
        return parent::count($q, $db);
    }

    public function all($db = null)
    {
        $this->visible();
        return parent::all($db);
    }

    public function one($db = null)
    {
        return parent::one($db);
    }
}
