<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\commands;

use Faker\Factory;
use Yii;
use app\helpers\App;
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
	public function actionTruncate($tables=[])
    {
        $tables = is_array($tables)? $tables: [$tables];

        foreach ($tables as $table) {
            Console::output("Truncate {$table}");
            App::truncateTable(App::tablePrefix() . $table);
        }
        Console::output("\n");
    }
}
