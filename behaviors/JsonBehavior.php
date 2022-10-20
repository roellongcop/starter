<?php

namespace app\behaviors;

use yii\db\ActiveRecord;

class JsonBehavior extends \yii\base\Behavior
{
    public $fields = [];

    public function events()
    {
        return [
            ActiveRecord::EVENT_BEFORE_INSERT => 'encode',
            ActiveRecord::EVENT_BEFORE_UPDATE => 'encode',
            ActiveRecord::EVENT_AFTER_FIND => 'decode',
            ActiveRecord::EVENT_INIT => 'decode',
        ];
    }

    public function encode($event)
    {
        if ($this->fields) {
            foreach ($this->fields as $e) {
                $data = $this->owner->{$e} ?: [];

                if (is_array($data)) {
                    $this->owner->{$e} = json_encode($data);
                }
            }
        }
    }

    public function decode($event)
    {
        if ($this->fields) {
            foreach ($this->fields as $e) {
                $data = $this->owner->{$e} ?: '[]';
                if (!is_array($data)) {
                    $this->owner->{$e} = json_decode($data, true);
                }
            }
        }
    }
}