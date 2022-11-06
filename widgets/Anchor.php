<?php

namespace app\widgets;

use Yii;
use app\helpers\App;
use yii\helpers\Html;
use app\helpers\Url;
use app\components\RequestComponent;

class Anchor extends BaseWidget
{
    public $title = 'title';
    public $link = [];
    public $options = [];
    public $text = false;
    public $controller;
    public $action;
    public $user;
    public $tooltip;

    public $stringLink;

    public function init() 
    {
        // your logic here
        parent::init();
        $this->stringLink = is_array($this->link)? Url::to($this->link): $this->link;
        $request = new RequestComponent(['url' => parse_url($this->stringLink, PHP_URL_PATH)]);
        $url = App::urlManager()->parseRequest($request);
        list($controller, $actionID) = App::app()->createController($url[0]);

        $this->controller = $controller ? $controller->id: '';
        $this->action = $actionID;

        if (is_array($this->link)) {
            $url = $this->link[0] ?? '';

            $explodedLink = explode('/', $url);
            if (count($explodedLink) == 1) {
                $this->controller = $this->controller ?: App::controllerID();
                $this->action = $this->action ?: $explodedLink[0];
            }
            else {
                $this->controller = $this->controller ?: $explodedLink[0];
                $this->action = $this->action ?: $explodedLink[1];
            }
        }

        $this->user = $this->user ?: App::user();
        $this->options['title'] = $this->options['title'] ?? $this->tooltip;
    }

    public function isExternal($url) 
    {
        $hostName = App::request('hostName');

        $components = parse_url($url);
        if ( empty($components['host']) ) {
            // we will treat url like '/relative.php' as relative
            return false;  
        }
        if ( strcasecmp($components['host'], $hostName) === 0 ) {
            // url host looks exactly like the local host
            return false; 
        } 
        // check if the url host is a subdomain
        return strrpos(strtolower($components['host']), ".{$hostName}") !== strlen($components['host']) - strlen(".{$hostName}"); 
    }


    /**
     * {@inheritdoc}
     */
    public function run()
    {
        if ($this->stringLink) {
                
            if ($this->isExternal($this->stringLink)) {
                return Html::a($this->title, $this->stringLink, $this->options);
            }

            if ($this->stringLink == '#' || $this->stringLink == '#!') {
                return Html::a($this->title, $this->stringLink, $this->options);
            }

            if (App::component('access')->userCan($this->action, $this->controller, $this->user)) {
                return Html::a($this->title, $this->stringLink, $this->options);
            }
        }

        if ($this->text) {
            return $this->title;
        }
    }
}
