<?php

namespace app\helpers;

use app\helpers\App;

class FixtureData
{
    public $data = [];
    public $function;

    function __construct($function)
    {
        $this->function = $function;
    }

    public function add($key='', $params=[], $replace=[])
    {
        $key = $key ?: implode('-', [App::randomString(), time()]);
        $this->data[$key] = array_replace(call_user_func($this->function, $params), $replace);
    }

    public function getData()
    {
        return $this->data;
    }
}