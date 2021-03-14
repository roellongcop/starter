<?php
namespace app\models\query;

use app\helpers\App;

abstract class ActiveQuery extends \yii\db\ActiveQuery
{
    abstract public function controllerID();


    public function visible($alias = '')
    {
        $field = "record_status";

        if ($alias) {
            $field = "{$alias}.record_status";
        }

        if ($this->from && is_array($this->from)) {
            $alias = array_keys($this->from)[0] ?? '';

            if ($alias) {
                $field = "{$alias}.record_status";
            }
        }



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
            'record_status' => 1
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
            'record_status' => 0
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
        // $this->visible();
        return parent::one($db);
    }
}
