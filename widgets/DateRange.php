<?php

namespace app\widgets;

class DateRange extends BaseWidget
{
    public $model;
    public $name;
    public $attribute = 'date_range';
    public $title = 'Date Range';
    public $start;
    public $end;
    public $all_start;
    public $all_end;

    public $ranges = [
        'All',
        'Today',
        'Yesterday',
        'Last 7 Days',
        'Last 30 Days',
        'This Month',
        'Last Month',
        'This Year',
        'Last Year',
    ];
    

    public function init() 
    {
        // your logic here
        parent::init();

        if (! $this->name) {
            $this->name = $this->attribute;
        }

        $this->id = "date-range-{$this->id}";

        if (! $this->start && $this->model->hasMethod('getStartDate')) {
            $this->start = $this->model->startDate;
        }
        else {
            $this->start = $this->start ?: date('F d, Y');
        }

        if (! $this->all_start && $this->model->hasMethod('getStartDate')) {
            $this->all_start = $this->model->getStartDate(true);
        }
        else {
            $this->all_start = $this->all_start ?: date('F d, Y');
        }

        if (! $this->end && $this->model->hasMethod('getEndDate')) {
            $this->end = $this->model->endDate;
        }
        else {
            $this->end = $this->end ?: date('F d, Y');
        }

        if (! $this->all_end && $this->model->hasMethod('getEndDate')) {
            $this->all_end = $this->model->getEndDate(true);
        }
        else {
            $this->all_end = $this->all_end ?: date('F d, Y');
        }
    }

    /**
     * {@inheritdoc}
     */
    public function run()
    {
        return $this->render('date-range', [
            'model' => $this->model,
            'id' => $this->id,
            'title' => $this->title,
            'name' => $this->name,
            'start' => $this->start,
            'end' => $this->end,
            'all_start' => $this->all_start,
            'all_end' => $this->all_end,
            'ranges' => json_encode($this->ranges),
        ]);
    }
}
