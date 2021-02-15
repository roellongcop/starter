<?php
namespace app\behaviors;
use app\helpers\App;
use yii\base\Behavior;
use yii\db\ActiveRecord;
use yii\helpers\Json;

class LogBehavior extends Behavior
{
    public $logAfterSave = true;
    public $logAfterDelete = true;

    public function init()
    {
        parent::init(); 
    }

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
        if ($this->owner->hasAttribute('logAfterSave')) {
            $this->logAfterSave = $this->owner->logAfterSave;
        }

        if ($this->logAfterSave) {
            App::component('logbook')->log($this->owner, $event->changedAttributes);
        }
        
    }
    public function afterDelete()
    {
        if ($this->owner->hasAttribute('logAfterDelete')) {
            $this->logAfterDelete = $this->owner->logAfterDelete;
        }
        
        if ($this->logAfterDelete) {
            App::component('logbook')->log($this->owner, $this->owner->attributes);
        }
    }
}