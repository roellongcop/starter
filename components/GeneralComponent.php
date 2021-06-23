<?php

namespace app\components;

use Yii;
use app\helpers\App;
use yii\base\Component;

class GeneralComponent extends Component
{
    public function getAllTables()
    {
        $tables = App::getTableNames();
        $tables = array_combine($tables, $tables);
        return $tables;
    }

    public function timezoneList($type='alpha_key') 
    {
        $arr = timezone_identifiers_list();

        switch ($type) {
            case 'alpha_key':
                return array_combine($arr, $arr);
                break;

            case 'numeric_key':
                return $arr;
                break;
            
            default:
                return $arr;
                break;
        }
    }
}