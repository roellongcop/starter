<?php

namespace app\gii\crud\starter;

use Yii;
use yii\gii\CodeFile;

class Generator extends \yii\gii\generators\crud\Generator
{
    public function generate()
    {
        $controllerFile = Yii::getAlias('@' . str_replace('\\', '/', ltrim($this->controllerClass, '\\')) . '.php');

        $files = [
            new CodeFile($controllerFile, $this->render('controller.php')),
        ];

        if (!empty($this->searchModelClass)) {
            $searchModel = Yii::getAlias('@' . str_replace('\\', '/', ltrim($this->searchModelClass, '\\') . '.php'));
            $files[] = new CodeFile($searchModel, $this->render('search.php'));
        }

        $viewPath = $this->getViewPath();
        $templatePath = $this->getTemplatePath() . '/views';
        foreach (scandir($templatePath) as $file) {
            if (empty($this->searchModelClass) && $file === '_search.php') {
                continue;
            }
            if (is_file($templatePath . '/' . $file) && pathinfo($file, PATHINFO_EXTENSION) === 'php') {
                $files[] = new CodeFile("$viewPath/$file", $this->render("views/$file"));
            }
        }

        if ($this->template == 'starter') {
            /*ADDED FOR UNIT TESTING SEARCH MODEL*/
            $exp = explode('\\', $this->controllerClass);
            $end = end($exp);

            $model = str_replace('Controller', '', $end);
            $params['modelClass'] = \yii\helpers\StringHelper::basename($this->modelClass);

            $files[] = new CodeFile(
                Yii::getAlias('@app') . '/tests/unit/models/search/' . $model . 'SearchTest.php',
                $this->render('search-model-test.php', $params)
            );
        }

        return $files;
    }
}