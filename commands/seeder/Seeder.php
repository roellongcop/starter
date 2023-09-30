<?php

namespace app\commands\seeder;

use Yii;
use Faker\Factory;
use app\helpers\App;
use app\models\ActiveRecord;
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
abstract class Seeder
{
    public abstract function attributes();

    public $success = 0;
    public $failed = 0;
    public $success_attributes = [];
    public $error_attributes = [];
    public $model_errors = [];
    public $faker;
    public $validation = true;

    public $rows;
    public $modelClass;
    public $insert;

    public $showProgress = true;
    public $totalRecords = 0;

    public function __construct()
    {
        $this->faker = Factory::create();
    }

    public function resetProperties()
    {
        $this->success = 0;
        $this->failed = 0;
        $this->success_attributes = [];
        $this->error_attributes = [];
        $this->model_errors = [];

        $this->showProgress = true;
        $this->totalRecords = 0;
    }

    public function recordStatus()
    {
        return $this->faker->randomElement([
            ActiveRecord::RECORD_ACTIVE,
            ActiveRecord::RECORD_INACTIVE,
        ]);
    }

    public function created_at()
    {
        return implode(' ', [$this->faker->date, $this->faker->time]);
    }

    public function actionTruncate($tables = [])
    {
        $tables = is_array($tables) ? $tables : [$tables];

        foreach ($tables as $table) {
            Console::output("Truncate {$table}");
            App::truncateTable(App::tablePrefix() . $table);
        }
        Console::output("\n");
    }

    public function startProgress($done = 0, $total = 0, $prefix = '', $width = 1)
    {
        if ($this->showProgress) {
            Console::startProgress($done, $total, $prefix, $width);
        }
    }

    public function save($model, $done = 1)
    {
        if ($model->save($this->validation)) {
            $this->success++;

            $this->success_attributes[$done] = $model->attributes;
        } else {
            $this->failed++;
            $this->model_errors[$done] = $model->errors;
            $this->error_attributes[$done] = $model->attributes;
        }

        if ($this->showProgress) {
            Console::updateProgress($done, $this->rows);
        }
        return $model;
    }

    public function summary()
    {
        if ($this->showProgress) {
            Console::endProgress("done." . PHP_EOL);
            echo Table::widget([
                'headers' => ['Success', 'Failed', 'Total'],
                'rows' => [
                    [
                        number_format($this->success),
                        number_format($this->failed),
                        number_format($this->totalRecords)
                    ],
                ],
            ]);
        }

        if ($this->failed > 0) {

            $rows = [];
            foreach ($this->model_errors as $row => $validation) {
                $rows[] = [$row, json_encode($validation)];
            }

            if ($this->showProgress) {
                Console::output('Unsuccessfull inserts.');
                echo Table::widget([
                    'headers' => ['Row', 'validation'],
                    'rows' => $rows,
                ]);
            }
        }

        if ($this->showProgress) {
            echo "\n";
        }

        $this->resetProperties();

        return ExitCode::OK;
    }

    public function seed()
    {
        $modelClass = is_array($this->modelClass) ? $this->modelClass['class'] : $this->modelClass;
        if ($this->showProgress) {
            $this->startProgress(0, $this->rows, "Seeding: {$modelClass} ");
        }

        for ($i = 1; $i <= $this->rows; $i++) {
            $model = Yii::createObject($this->modelClass);
            $model->load([App::className($model) => $this->attributes()]);

            if ($model->hasProperty('logAfterSave')) {
                $model->logAfterSave = false;
            }

            $newModel = $this->save($model, $i);

            if ($this->insert) {
                call_user_func($this->insert, $newModel, $i);
            }
        }

        if ($this->showProgress) {
            if (method_exists($this, 'total')) {
                $this->totalRecords = $this->total();
            } else {
                $result = $modelClass::find()
                    ->select(['COUNT("*") as total'])
                    ->createCommand()
                    ->queryOne();

                $this->totalRecords = $result['total'];
            }

            $this->summary();
        }
    }

    public function seeder($conf = '')
    {
        $seeder = Yii::createObject($conf);
        $seeder->seed();
    }
}