<?php
namespace app\widgets;

use Yii;
 
class JsonEditor extends \yii\base\Widget
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
        return $this->render('json_editor', [
            'data' => $this->data,
            'id' => $this->id,
            'options' => $this->options,
        ]);
    }
}
