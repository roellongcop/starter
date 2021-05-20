<?php
namespace app\widgets;

use Yii;
use app\helpers\App;
 
class DateRange extends \yii\base\Widget
{
    public $model;
    public $name;
    public $attribute = 'date_range';
    public $title = 'Date Range';
    public $start;
    public $end;
    public $all_start;
    public $all_end;
    

    public function init() 
    {
        // your logic here
        parent::init();
        if (! $this->name) {
            $this->name = $this->attribute;
        }

        $this->id = "date-range-{$this->id}";

        if (! $this->start) {
            $this->start = (method_exists($this->model, 'getStartDate'))? 
                $this->model->startDate: date('F d, Y');
        }

        if (! $this->all_start) {
            $this->all_start = (method_exists($this->model, 'getStartDate'))?
                    $this->model->getStartDate(true): date('F d, Y');
        }

        if (! $this->end) {
            $this->end = (method_exists($this->model, 'getEndDate'))? 
                $this->model->endDate: date('F d, Y');
        }

        if (! $this->all_end) {
            $this->all_end = (method_exists($this->model, 'getEndDate'))? 
                $this->model->getEndDate(true): date('F d, Y');
        }
    }

    /**
     * {@inheritdoc}
     */
    public function run()
    {
        return $this->render('date_range', [
            'model' => $this->model,
            'id' => $this->id,
            'title' => $this->title,
            'name' => $this->name,
            'start' => $this->start,
            'end' => $this->end,
            'all_start' => $this->all_start,
            'all_end' => $this->all_end,
        ]);
    }
}
