<?php
namespace app\widgets;

use Yii;
use app\helpers\App;
use app\widgets\Switcher;
use yii\helpers\Url;
 
class RecordHtml extends \yii\base\Widget
{
    public $model;
    public $labelOnly = false;

    public function init() 
    {
        // your logic here
        parent::init();
    }


    /**
     * {@inheritdoc}
     */
    public function run()
    {
        if ($this->labelOnly) {
            return $this->render('record_html', [
                'model' => $this->model
            ]);
        }

        return Switcher::widget([
            'model' => $this->model,
            'checked' => ($this->model->record_status == 1),
            'controller' => $controller ?? App::controllerID(),
            'action' => 'change-record-status'
        ]);
    }
}
