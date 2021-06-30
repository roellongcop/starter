<?php
namespace app\behaviors;

use app\helpers\App;
use yii\base\Behavior;
use yii\db\ActiveRecord;

class ProcessBehavior extends Behavior
{
    public function getCanDelete()
    {
        $res = [];
        if (($relatedModels = $this->owner->relatedModels) != null) {
            foreach ($relatedModels as $model) {
                if ($this->owner->{$model}) {
                    $res[] = $model;
                }
            }
        }
        return ($res)? false: true;
    }

    public function getCanCreate()
    {
        return true;
    }
    
    public function getCanView()
    {
        return true;
    }

    public function getCanUpdate()
    {
        return true;
    }

    public function getCanActivate()
    {
        if (App::isGuest()) {
            return true;
        }

        if (App::identity()->can('change-record-status', $this->owner->controllerID())) {
            return true;
        }

        return false;
    }

    public function getCanDeactivate()
    {
        if (App::isLogin()) {
            $user = App::identity();

            if ($user->can('in-active-data', $this->owner->controllerID())
                && $user->can('change-record-status', $this->owner->controllerID())
            ) {
                return true;
            }
        }

        return false;
    }

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