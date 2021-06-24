<?php
namespace app\behaviors;

use app\helpers\App;
use yii\base\Behavior;
use yii\db\ActiveRecord;

class ProcessBehavior extends Behavior
{
    public function events()
    {
        return [
            ActiveRecord::EVENT_BEFORE_INSERT => 'beforeInsert',
            ActiveRecord::EVENT_BEFORE_UPDATE => 'beforeUpdate',
            ActiveRecord::EVENT_BEFORE_DELETE => 'beforeDelete',
        ];
    }

    public function beforeInsert($event)
    {
        $event->isValid = $this->owner->canCreate;

        if (! $event->isValid) {
            $attributes = $this->owner->attributes;
            foreach ($attributes as $attribute => $value) {
                $this->owner->addError($attribute, 'Data cannot be Created');
            }
        }
    }

    public function beforeUpdate($event)
    {
        $event->isValid = $this->owner->canUpdate;
        if (! $event->isValid) {
            $attributes = $this->owner->attributes;
            foreach ($attributes as $attribute => $value) {
                $this->owner->addError($attribute, 'Data cannot be Updated');
            }
        }
    }

    public function beforeDelete($event)
    {
        $event->isValid = $this->owner->canDelete;
        if (! $event->isValid) {
            $attributes = $this->owner->attributes;
            foreach ($attributes as $attribute => $value) {
                $this->owner->addError($attribute, 'Data cannot be Deleted');
            }
        }
    }
}