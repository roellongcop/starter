<?php

namespace app\widgets;

class JsonEditor extends BaseWidget
{
    public $data;
    public $options = [
        'mode' =>  'view'
    ];
    
    

    public function init() 
    {
        // your logic here
        parent::init();
        
        $this->data = $this->data ?: [];
        $this->data = is_array($this->data)? json_encode($this->data): $this->data;
        $this->data = strip_tags($this->data);
        $this->options = json_encode($this->options);
    }

    /**
     * {@inheritdoc}
     */
    public function run()
    {
        return $this->render('json-editor', [
            'data' => $this->data,
            'id' => $this->id,
            'options' => $this->options,
        ]);
    }
}
