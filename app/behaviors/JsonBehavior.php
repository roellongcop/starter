<?php
namespace app\behaviors;

use yii\base\Behavior;
use yii\db\ActiveRecord;
use yii\helpers\Json;

class JsonBehavior extends Behavior
{
    public $fields;

    public function events()
    {
        return [
            ActiveRecord::EVENT_BEFORE_INSERT => 'beforeSave',
            ActiveRecord::EVENT_AFTER_FIND => 'afterFindData',
        ];
    }

    public function beforeSave($event)
    {
        $arrayAttr = (isset($this->owner->arrayAttr))? $this->owner->arrayAttr: $this->fields;

        foreach ($arrayAttr as $e) {
            if (is_array($this->owner->{$e})) {
                $this->owner->{$e} = Json::encode($this->owner->{$e});
            }
        }
    }

    public function afterFindData($event)
    {
        $arrayAttr = (isset($this->owner->arrayAttr))? $this->owner->arrayAttr: $this->fields;
        foreach ($arrayAttr as $e) {
            if (!is_array($this->owner->{$e})) {
                $this->owner->{$e} = $this->owner->{$e}? Json::decode($this->owner->{$e}, TRUE): [];
            }
        }
    }
}