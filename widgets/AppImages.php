<?php

namespace app\widgets;

use Yii;
use app\helpers\App;
use yii\helpers\Url;
 
class AppImages extends \yii\base\Widget
{
    public $model;
    public $removeImageUrl;
    public $user;

    public function init() 
    {
        // your logic here
        parent::init();

        $this->user = $this->user ?: App::identity();
        $this->removeImageUrl = $this->removeImageUrl ?: ['file/delete'];
    }


    /**
     * {@inheritdoc}
     */
    public function run()
    {
        return $this->render('app_images', [
            'model' => $this->model,
            'removeImageUrl' => $this->removeImageUrl,
            'removeImagePath' => Url::to($this->removeImageUrl),
            'user' => $this->user,
        ]);
    }
}
