<?php

namespace app\jobs;

use Yii;
use app\helpers\App;
use app\models\Backup;
use app\models\ModelFile;
use yii\helpers\FileHelper;

class BackupJob extends \yii\base\BaseObject implements \yii\queue\JobInterface
{
    public $backupId;
    
    public function execute($queue)
    {
    	$model = Backup::findOne($this->backupId);

        if ($model) {
            $backup = $this->backupDB($model->filename, $model->tables);

            if ($backup) {
                $fileInput = new \StdClass();
                $fileInput->baseName = $model->filename;
                $fileInput->extension = 'sql';
                $fileInput->size = $backup['filesize'];

                $file = App::component('file')->saveFile($model, $fileInput, $backup['uploadPath']);

                $modelFile = new ModelFile([
                    'file_id' => $file->id,
                    'model_id' => $model->id,
                    'extension' => $file->extension,
                    'model_name' => App::getModelName($model),
                ]);
                $modelFile->save();
            }
        }
    }

    public function backupDB($name='', $tables='') 
    {
        $name = $name ?: time();
        $tables = $tables ?: '*';

        $micro_date = microtime();
        $date_array = explode(" ",$micro_date);
        $uploadPath = $this->uploadPath($name);
        $filepath = implode('/', [Yii::getAlias('@consoleWebroot'), $uploadPath]);

        if ($tables == '*') {
            $tables = array();
            $tables = App::getTableNames();
        } 
        else {
            $tables = is_array($tables) ? $tables : explode(',', $tables);
        }
        $return = '';
        foreach ($tables as $table) {
            $result = App::query("SELECT * FROM {$table}");
            $return.= 'DROP TABLE IF EXISTS `' . $table . '`;';
            $row2 = App::queryOne("SHOW CREATE TABLE {$table}");
            $return.= "\n\n" . $row2['Create Table'] . ";\n\n";
            foreach ($result as $row) {
                $return.= 'INSERT INTO ' . $table . ' VALUES(';
                foreach ($row as $data) {
                    $data = addslashes($data);
                    $data = preg_replace("/\n/", "\\n", $data);
                    if (isset($data)) {
                        $return.= "'" . $data . "'";
                    } 
                    else {
                        $return.= '""';
                    }
                    $return.= ',';
                }
                $return = substr($return, 0, strlen($return) - 1);
                $return.= ");\n";
            }
            $return.="\n\n\n";
        }
        $handle = fopen($filepath, 'w+');
        fwrite($handle, $return);
        fclose($handle);

        if (file_exists($filepath)) {

            return [
                'filesize' => filesize($filepath),
                'filepath' => $filepath,
                'uploadPath' => $uploadPath
            ];
        }
        return false;
    }

    public function uploadPath($name)
    {
        $folders = [
            'protected',
            'backups',
            date('Y'),
            date('m'),
        ];

        $file_path = implode('/', $folders);
        FileHelper::createDirectory(implode('/', [Yii::getAlias('@consoleWebroot'), $file_path]));

        App::component('file')->createIndexFile($folders);

        $path = "{$file_path}/{$name}.sql";

        return $path;
    }
}