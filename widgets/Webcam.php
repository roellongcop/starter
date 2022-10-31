<?php

namespace app\widgets;

use Yii;
use app\helpers\App;
 
class Webcam extends BaseWidget
{
    public $model;
    public $modelName;
    public $ajaxSuccess;
    public $attribute;
    public $buttonLabel;

    public $withNameInput = true;

    public $withInput = true;

    public $tag;

    public $videoOptions = [
        'width' => 2600,
        'height' => 1900,
        'autoplay' => true,
        'style' => 'margin: 0 auto;width: 100%; height: auto;max-width: 400px;'
    ];

    public $buttonOptions = [
        'class' => 'btn btn-primary btn-sm mt-3',
        'value' => 'Capture',
        'style' => 'margin: 0 auto;max-width: 200px'
    ];

    public $canvasOptions = [
        // 'width' => 300,
        // 'height' => 300,
        'style' => 'display: none;width:300px; height: 300px'
    ];
   
    public function init() 
    {
        parent::init();

        $this->videoOptions['id'] = "webcam-video-{$this->id}";
        $this->buttonOptions['id'] = "webcam-capture-{$this->id}";
        $this->canvasOptions['id'] = "webcam-canvas-{$this->id}";

        $this->buttonOptions['value'] = $this->buttonLabel ?: $this->buttonOptions['value'];

        $this->modelName = App::className($this->model);

        if ($this->withInput) {
            $this->ajaxSuccess .= <<< JS
                $('#webcam-container-{$this->id} input').val(s.file.token);
            JS;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function run()
    {
        return $this->render('webcam/index', [
            'model' => $this->model,
            'attribute' => $this->attribute,
            'videoOptions' => $this->videoOptions,
            'buttonOptions' => $this->buttonOptions,
            'canvasOptions' => $this->canvasOptions,
            'ajaxSuccess' => $this->ajaxSuccess,
            'modelName' => $this->modelName,
            'withInput' => $this->withInput,
            'withNameInput' => $this->withNameInput,
            'tag' => $this->tag,

            'videoOptionsEncoded' => json_encode($this->videoOptions),
            'buttonOptionsEncoded' => json_encode($this->buttonOptions),
            'canvasOptionsEncoded' => json_encode($this->canvasOptions),
        ]);
    }
}
