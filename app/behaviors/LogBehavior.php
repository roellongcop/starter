<?php
namespace app\behaviors;

use app\helpers\App;
use yii\base\Behavior;
use yii\db\ActiveRecord;

class LogBehavior extends Behavior
{
    public $logAfterSave = true;
    public $logAfterDelete = true;

    public function events()
    {
        return [
            ActiveRecord::EVENT_AFTER_DELETE => 'afterDelete',
            ActiveRecord::EVENT_AFTER_INSERT => 'afterSave',
            ActiveRecord::EVENT_AFTER_UPDATE => 'afterSave',
        ];
    }


    public function afterDelete($event)
    {
        $owner = $this->owner;
        $logAfterDelete = isset($owner->logAfterDelete)? $owner->logAfterDelete: $this->logAfterDelete;

        if ($logAfterDelete) {
            App::component('logbook')->log($owner, $owner->attributes);
        }
    }

    public function afterSave($event)
    {
        $logAfterSave = isset($owner->logAfterSave)? $owner->logAfterSave: $this->logAfterSave;
        $owner = $this->owner;
        if ($logAfterSave) {
            App::component('logbook')->log($owner, $event->changedAttributes);
        }
    }

}