<?php

namespace app\modules\api\v1\models\sub;

use Yii;
use app\helpers\App;
use app\modules\api\v1\models\User;

class UserAvailable extends User
{
  
    public function getDefaultPassword()
    {
        return $this->email;
    }

    public static function findAll($condition=[])
    {
        return self::find()
            ->andWhere($condition)
            ->all();
    }

    public static function find()
    {
        return parent::find()
            ->where([
                'record_status' => 1,
                'status' => 10,
                'is_blocked' => 0
            ]);
    }


    public function fields()
    {
        return [
            'email',
            'defaultPassword',
        ];
    }
}
