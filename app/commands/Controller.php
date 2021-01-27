<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\commands;

use Yii;
use app\helpers\App;
// use yii\console\Controller;
use yii\console\ExitCode;
use yii\console\widgets\Table;
use yii\helpers\Console;

/**
 * This command echoes the first argument that you have entered.
 *
 * This command is provided as an example for you to learn how to create console commands.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
abstract class Controller extends \yii\console\Controller
{
    public $success = 0;
    public $failed = 0;
    public $success_attributes = [];
    public $error_attributes = [];
    public $model_errors = [];

    public function truncate($tables=[])
    {
        foreach ($tables as $table) {
            Console::output("Truncate {$table}");
            Yii::$app->db->createCommand()
                ->truncateTable(Yii::$app->db->tablePrefix . $table)
                ->execute();
        }
        Console::output("\n");
    }


    public function startProgress($done=0, $total, $prefix='', $width=1)
    {
        Console::startProgress($done, $total, $prefix, $width);
    }
 
    // ==========================================================================================
    public function save($model, $done=1, $total=0)
    {
        if ($model->save()) {
            $this->success++;

            $this->success_attributes[$done] = $model->attributes;
        }
        else {
            $this->failed++;
            $this->model_errors[$done] = $model->errors;
            $this->error_attributes[$done] = $model->attributes;
        }

        Console::updateProgress($done, $total);
        return $model;
    }

    

    public function summary($total=0)
    {
        Console::endProgress("done." . PHP_EOL);

        echo Table::widget([
            'headers' => ['Success', 'Failed', 'Total'],
            'rows' => [
                [
                    number_format($this->success), 
                    number_format($this->failed), 
                    number_format($total)
                ],
            ],
        ]);

        if ($this->failed > 0) {
            Console::output('Unsuccessfull inserts.');

            $rows = [];
            foreach ($this->model_errors as $row => $validation) {
                $rows[] = [$row, json_encode($validation)];
            }

            echo Table::widget([
                'headers' => ['Row', 'validation'],
                'rows' => $rows,
            ]);
        }

        $this->success = 0;
        $this->failed = 0;

        echo "\n";
        return ExitCode::OK;
    }
 

}
