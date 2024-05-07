<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\commands;

use Yii;
use yii\helpers\Inflector;
use Faker\Factory;
use app\commands\models\Ip;
use yii\helpers\Console;
use yii\db\Expression;
/**
 * This command echoes the first argument that you have entered.
 *
 * This command is provided as an example for you to learn how to create console commands.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class SeedController extends Controller
{
    public function actionInit()
    {
        $this->actionTruncate(['users', 'roles', 'ips']);
        $classes = [
            'Role',
            'User',
            'Ip',
        ];

        foreach ($classes as $class) {
            $this->actionIndex($class, 5);
        }
    }

    public function actionIndex($class, $rows = 1)
    {
        $class = Inflector::id2camel($class);
        $model = Yii::createObject([
            'class' => "\\app\\commands\\seeder\\{$class}Seeder",
            'rows' => $rows
        ]);
        $model->seed();
    }

    public function actionTest($rows=1)
    {
        $faker = Factory::create();
        $data = [];
        $start = time();
        Console::output("Start: {$start}");
        for ($i = 1; $i <= $rows; $i++) {
            $ip = $faker->ipv4;
            $data[] = [
                'name' => $ip,
                'slug' => $ip . "-" . $i,
                'description' => $faker->text,
                'type' => $faker->randomElement([
                    Ip::TYPE_BLACKLIST,
                    Ip::TYPE_WHITELIST,
                ]),
                'record_status' => 1,
                'created_at' => new Expression('UTC_TIMESTAMP'),
                'updated_at' =>  new Expression('UTC_TIMESTAMP')
            ];
        }

        $end = time();
        Console::output("End: {$end}");

        // Calculate the difference in seconds
        $difference = $end - $start;

        // Format the difference in hours:minutes:seconds
        $hours = floor($difference / 3600);
        $minutes = floor(($difference % 3600) / 60);
        $seconds = $difference % 60;

        Console::output("hours: {$hours}");
        Console::output("minutes: {$minutes}");
        Console::output("seconds: {$seconds}");

        Ip::batchInsert($data);
    }
}