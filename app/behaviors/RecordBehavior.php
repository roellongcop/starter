<?php
namespace app\behaviors;

use app\helpers\App;
use app\widgets\RecordHtml;
use yii\db\ActiveRecord;

class RecordBehavior extends \yii\base\Behavior
{
    public $recordStatus;
    public $recordStatusLabel;
    public $recordStatusHtml;
    public $controller;


    public function events()
    {
        return [
            ActiveRecord::EVENT_AFTER_FIND => 'afterFind',
        ];
    }

    public function afterFind($event)
    {
        $this->recordStatus = App::params('record_status')[$this->owner->record_status] ?? [];
        $this->recordStatusLabel = $this->recordStatus['label'] ?? '';
        
        if (in_array(App::actionID(), App::params('export_actions'))) {
            $this->recordStatusHtml = $this->recordStatusLabel;
        }
        else if (App::isLogin() && App::identity()->can('change-record-status', $this->controller)) {
            $this->recordStatusHtml = RecordHtml::widget([
                'model' => $this->owner,
                'controller' => $this->controller,
            ]);
        }
        else {

            $this->recordStatusHtml = RecordHtml::widget([
                'model' => $this->owner,
                'labelOnly' => true
            ]);
        }
    }
}