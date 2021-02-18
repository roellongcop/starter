<?php
namespace app\widgets;

use Yii;
use app\helpers\App;
use yii\helpers\Html;
use yii\helpers\Url;
 
class Anchor extends \yii\base\Widget
{
    public $title = 'title';
    public $link = [];
    public $options = [];
    public $text = false;
    public $controller;
    public $action;
    public $user;
    public $tooltip = 'Click to view';

    public function init() 
    {
        // your logic here
        parent::init();


        if (is_array($this->link)) {
            $url = $this->link[0];

            $explodedLink = explode('/', $url);
            if (count($explodedLink) == 1) {
                $this->controller = App::controllerID();
                $this->action = $explodedLink[0];
            }
            else {
                $this->controller = $explodedLink[0];
                $this->action = $explodedLink[1];
            }
        }
        $this->user = $this->user ?: App::user();
        $this->options['title'] = $this->tooltip;
    }


    /**
     * {@inheritdoc}
     */
    public function run()
    {
        if (!is_array($this->link)) {
            return Html::a($this->title, $this->link, $this->options);
        }

        if (App::component('access')->userCan($this->action, $this->controller, $this->user)) {

            return Html::a($this->title, $this->link, $this->options);
        }

        if ($this->text) {
            return $this->title;
        }
    }
}
