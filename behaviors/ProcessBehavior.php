<?php

namespace app\behaviors;

use app\helpers\App;
use yii\db\ActiveRecord;

class ProcessBehavior extends \yii\base\Behavior
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
            $this->owner->addError($this->owner->mainAttribute(), 'Data cannot be created');
        }
    }

    public function beforeUpdate($event)
    {
        $event->isValid = $this->owner->canUpdate;
        if (! $event->isValid) {
            $this->owner->addError($this->owner->mainAttribute(), 'Data cannot be updated');
        }
    }

    public function beforeDelete($event)
    {
        $event->isValid = $this->owner->canDelete;
        if (! $event->isValid) {
            $this->owner->addError($this->owner->mainAttribute(), 'Data cannot be deleted');
        }
    }
}