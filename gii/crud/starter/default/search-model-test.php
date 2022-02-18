<?= "<?php\n" ?>

namespace tests\unit\models\search;

use app\models\search\<?= $modelClass ?>Search;

class <?= $modelClass ?>SearchTest extends \Codeception\Test\Unit
{
    public function _before()
    {
        \Yii::$app->user->login($this->tester->grabRecord('app\models\User', [
            'username' => 'developer'
        ]));
    }

    public function testSearchWithResult()
    {
        $searchModel = new <?= $modelClass ?>Search();
        $dataProviders = $searchModel->search(['<?= $modelClass ?>Search' => ['keywords' => '']]);
        expect_that($dataProviders);
        expect($dataProviders->totalCount)->equals(2);
    }

    public function testSearchWithNoResult()
    {
        $searchModel = new <?= $modelClass ?>Search();
        $dataProviders = $searchModel->search([
            '<?= $modelClass ?>Search' => ['keywords' => 'qwertyuiopasdfghjkl234567890']
        ]);

        expect_that($dataProviders);
        expect($dataProviders->totalCount)->equals(0);
    }
}