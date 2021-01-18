<?php
namespace app\behaviors;

use yii\base\Behavior;
use yii\db\ActiveRecord;
use yii\db\BaseActiveRecord;
use yii\helpers\Json;

class JsonBehavior extends Behavior
{

    public function events()
    {
        return [
            ActiveRecord::EVENT_BEFORE_INSERT => 'beforeSave',
            // BaseActiveRecord::EVENT_AFTER_FIND => 'afterFind',
        ];
    }

    public function beforeSave($event)
    {
        if (isset($this->owner->arrayAttr)) {
            foreach ($this->owner->arrayAttr as $e) {
                if (is_array($this->owner->{$e})) {
                    $this->owner->{$e} = Json::encode($this->owner->{$e});
                }
            }
        }
    }

    public function afterFind($event)
    {
        if (isset($this->owner->arrayAttr)) {
            foreach ($this->owner->arrayAttr as $e) {
                if (!is_array($this->owner->{$e})) {
                    $this->owner->{$e} = $this->owner->{$e}? Json::decode($this->owner->{$e}, TRUE): [];
                }
            }
        }
    }
}