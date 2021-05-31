<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\commands;

use Yii;
use app\helpers\App;
use yii\helpers\Console;

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
            'User',
            'Ip',
        ];

        foreach ($classes as $class) {
            $this->actionIndex($class, 5);
        }
    }

    public function actionIndex($class, $rows=1)
    {
        $model = Yii::createObject([
            'class' => "\\app\\commands\\seeder\\{$class}Seeder",
            'rows' => $rows
        ]);
        $model->seed();
    }
}
