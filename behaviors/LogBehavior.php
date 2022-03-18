<?php

namespace app\behaviors;

use app\helpers\App;
use app\models\Log;
use yii\db\ActiveRecord;

class LogBehavior extends \yii\base\Behavior
{
    public $logAfterSave = true;
    public $logAfterDelete = true;

    public function events()
    {
        return [
            ActiveRecord::EVENT_AFTER_INSERT => 'afterSave',
            ActiveRecord::EVENT_AFTER_UPDATE => 'afterSave',
            ActiveRecord::EVENT_AFTER_DELETE => 'afterDelete',
        ];
    }

    public function afterSave($event)
    {
        if ($this->owner->hasProperty('logAfterSave')) {
            $this->logAfterSave = $this->owner->logAfterSave;
        }

        if ($this->logAfterSave) {
            Log::record($this->owner, $event->changedAttributes);
        }
    }

    public function afterDelete()
    {
        if ($this->owner->hasProperty('logAfterDelete')) {
            $this->logAfterDelete = $this->owner->logAfterDelete;
        }
        
        if ($this->logAfterDelete) {
            Log::record($this->owner, $this->owner->attributes);
        }
    }
}