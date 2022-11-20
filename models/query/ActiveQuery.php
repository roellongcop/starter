<?php

namespace app\models\query;

use Yii;
use app\helpers\App;
use app\models\ActiveRecord;

class ActiveQuery extends \yii\db\ActiveQuery
{
    public function daterange($daterange='', $field='')
    {
        $model = Yii::createObject($this->modelClass);
        if ($model && $model->hasProperty('dateAttribute')) {
            $field = $field ?: $model->dateAttribute;
        }

        if ($daterange) {
            $field = $this->field($field);
            
            $hours = App::formatter()->asDateToTimezone(date("Y-m-d H:i:s"), "P");

            return $this->andFilterWhere([
                "between", 
                "date(DATE_ADD({$field},INTERVAL '{$hours}' HOUR_MINUTE))", 
                App::formatter()->asDaterangeToSingle($daterange, 'start'), 
                App::formatter()->asDaterangeToSingle($daterange, 'end'), 
            ]);
        }

        return $this;
    }

    public function _getAlias()
    {
        $tableNameAndAlias = $this->getTableNameAndAlias();

        if (isset($tableNameAndAlias[1])) {
            return $tableNameAndAlias[1];
        }
    }
    
    public function field($field)
    {
        if (($alias = $this->_getAlias()) != null) {
            return "{$alias}.{$field}";
        }
        return $field;
    }

    public function visible()
    {
        $model = Yii::createObject($this->modelClass);

        $field = $this->field('record_status');
        $condition[$field] = 1;

        if (App::isGuest()) {
            return $this->andFilterWhere($condition);
        }

        if ($model && $model->hasMethod('controllerID') && App::isLogin()) {

            if (App::identity()->can('in-active-data', $model->controllerID())) {
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
                $condition["{$a}.record_status"] = ActiveRecord::RECORD_ACTIVE;
            }

            return $this->andWhere($condition);
        }

        return $this->andWhere([
            $this->field('record_status') => ActiveRecord::RECORD_ACTIVE
        ]);
    }

    public function inActive($alias='')
    {
        if ($alias) {
            $alias = is_array($alias)? $alias: [$alias];
            
            $condition = [];

            foreach ($alias as $a) {
                $condition["{$a}.record_status"] = ActiveRecord::RECORD_INACTIVE;
            }

            return $this->andWhere($condition);
        }

        return $this->andWhere([
            $this->field('record_status') => ActiveRecord::RECORD_INACTIVE
        ]);
    }

    public function count($q = '*', $db = null)
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

    public function sum($q, $db = null) 
    {
        $this->visible();
        return parent::sum($q, $db);
    }

    public function average($q, $db = null) 
    {
        $this->visible();
        return parent::average($q, $db);
    }

    public function min($q, $db = null) 
    {
        $this->visible();
        return parent::min($q, $db);
    }

    public function max($q, $db = null) 
    {
        $this->visible();
        return parent::max($q, $db);
    }

    public function scalar($db = null) 
    {
        return parent::scalar($db);
    }

    public function column($db = null) 
    {
        return parent::column($db);
    }

    public function exists($db = null) 
    {
        return parent::exists($db);
    }
}