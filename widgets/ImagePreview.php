<?php

namespace app\widgets;

use app\helpers\App;

class ImagePreview extends BaseWidget
{

    public $model;
    public $attribute;
    public $options = [
        'class' => 'img-thumbnail',
        'loading' => 'lazy',
        'style' => 'max-height:200px',
    ];
    public $src;
    public $imageId;
    public $imageClass = 'img-thumbnail';

    public function init()
    {
        // your logic here
        parent::init();
        $arr = [
            strtolower(App::getModelName($this->model)),
            strtolower($this->attribute),
        ];
        $this->imageId = implode('-', $arr);

        $arr[] = 'preview';

        $this->options['id'] = implode('-', $arr);
        $this->options['class'] = $this->imageClass;
    }

    /**
     * {@inheritdoc}
     */
    public function run()
    {
        return $this->render('image-preview', [
            'src' => $this->src,
            'options' => $this->options,
            'imageId' => $this->imageId,
        ]);
    }
}