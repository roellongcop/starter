<?php
namespace app\commands\seeder;
use Faker\Factory;
use app\helpers\App;
use yii\console\ExitCode;
use yii\console\widgets\Table;
use yii\helpers\Console;
use Yii;
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

    public $rows;
    public $modelClass;

    public function __construct()
    {
        $this->faker = Factory::create();
    }

    public function recordStatus()
    {
        return $this->randomParamsID('record_status');
    }
    public function created_at()
    {
        return implode(' ', [$this->faker->date, $this->faker->time]);
    }

    public function randomParamsID($key='record_status')
    {
        return $this->faker->randomElement(App::keyMapParams($key));
    }

    public function actionTruncate($tables=[])
    {
        $tables = is_array($tables)? $tables: [$tables];

        foreach ($tables as $table) {
            Console::output("Truncate {$table}");
            App::truncateTable(App::tablePrefix() . $table);
        }
        Console::output("\n");
    }

    public function startProgress($done=0, $total, $prefix='', $width=1)
    {
        Console::startProgress($done, $total, $prefix, $width);
    }
 
    public function save($model, $done=1)
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

        Console::updateProgress($done, $this->rows);
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

    public function seed()
    {
        $modelClass = is_array($this->modelClass)? $this->modelClass['class']: $this->modelClass;
        $modelName = $this->startProgress(0, $this->rows, "Seeding: {$modelClass} ");

        for ($i=1; $i <= $this->rows; $i++) { 
            $model = Yii::createObject($this->modelClass);
            $model->load([App::className($model) => $this->attributes()]);

            if ($model->hasProperty('logAfterSave')) {
                $model->logAfterSave = false;
            }

            $newModel = $this->save($model, $i);
        }

        $result = $modelClass::find()
            ->select(['COUNT("*") as total'])
            ->createCommand()
            ->queryOne();
            
        $this->summary($result['total']);
    }
}
