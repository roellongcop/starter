<?php
namespace app\behaviors;

use yii\base\Behavior;
use yii\db\ActiveRecord;

class JsonBehavior extends Behavior
{
    public $fields = [];

    public function events()
    {
        return [
            ActiveRecord::EVENT_BEFORE_INSERT => 'beforeSave',
            ActiveRecord::EVENT_BEFORE_UPDATE => 'beforeSave',
            ActiveRecord::EVENT_AFTER_FIND => 'afterFind',
        ];
    }

    public function beforeSave($event)
    {
        if ($this->fields) {
            foreach ($this->fields as $e) {
                if (is_array($this->owner->{$e})) {
                    $this->owner->{$e} = json_encode($this->owner->{$e});
                }
            }
        }
    }

    public function afterFind($event)
    {
        if ($this->fields) {
            foreach ($this->fields as $e) {
                if (!is_array($this->owner->{$e})) {
                    $this->owner->{$e} = json_decode($this->owner->{$e}, TRUE);
                }
            }
        }
    }
}