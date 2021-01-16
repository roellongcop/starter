<?php
namespace app\components;

use Yii;
use app\helpers\App;
use yii\base\Component;

/**
 * 
 */
class GeneralComponent extends Component
{

    public function betweenRange($date_range, $field='created_at')
    {
        $hours = App::date_timezone(date("Y-m-d H:i:s"), "P");

        return [
            "between", 
            "date(DATE_ADD({$field},INTERVAL '{$hours}' HOUR_MINUTE))", 
            App::dateRange($date_range, 'start'), 
            App::dateRange($date_range, 'end'), 
        ];
    }

 

    public function getAllTables()
    {
        $tables = Yii::$app->db->schema->getTableNames();
        $tables = array_combine($tables, $tables);
        return $tables;
    } 
    
}