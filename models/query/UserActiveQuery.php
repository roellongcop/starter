<?php

namespace app\models\query;

use Yii;
use app\helpers\App;

class UserActiveQuery extends MainActiveQuery
{
    public function one($db = null)
    {
        if (App::isGuest()) {
            $this->visible();
        }
        return parent::one($db);
    }
}