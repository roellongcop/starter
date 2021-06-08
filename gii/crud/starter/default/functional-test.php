<?php

use yii\helpers\StringHelper;
use yii\helpers\Inflector;

$modelClass = StringHelper::basename($generator->modelClass);
?>
<?= '<?php' ?>

use app\models\User;
use <?= ltrim($generator->modelClass, '\\') ?>;

// Admin page functional test cest file. Move this file to @app\tests\functional\admin_pages

class <?= $modelClass ?>Cest
{
    public $user;
    public $model;

    public function _before(FunctionalTester $I)
    {
        $this->user = User::findByUsername('developer');
        $this->model = <?= $modelClass ?>::findOne(1);
        $I->amLoggedInAs($this->user);
    }

    public function _after(FunctionalTester $I)
    {
        Yii::$app->user->logout();
    }

    public function indexPage(FunctionalTester $I)
    {
        $I->amOnPage($this->model->getIndexUrl(false));
        $I->see(<?= $generator->generateString(Inflector::pluralize(Inflector::camel2words(StringHelper::basename($generator->modelClass)))) ?>, 'h5');
    }

    public function createPage(FunctionalTester $I)
    {
        $I->amOnPage($this->model->getCreateUrl(false));
        $I->see(<?= $generator->generateString('Create '. Inflector::camel2words(StringHelper::basename($generator->modelClass))) ?>, 'h5');
    }

    public function viewPage(FunctionalTester $I)
    {
        $I->amOnPage($this->model->getViewUrl(false));
        $I->see('<?= Inflector::camel2words(StringHelper::basename($generator->modelClass)) ?>:', 'h5');
    }

    public function updatePage(FunctionalTester $I)
    {
        $I->amOnPage($this->model->getUpdateUrl(false));
        $I->see('Update <?= Inflector::camel2words(StringHelper::basename($generator->modelClass)) ?>:', 'h5');
    }

    public function duplicatePage(FunctionalTester $I)
    {
        $I->amOnPage($this->model->getDuplicateUrl(false));
        $I->see('Duplicate <?= Inflector::camel2words(StringHelper::basename($generator->modelClass)) ?>:', 'h5');
    }


    public function bulkActionPage(FunctionalTester $I)
    {
        $I->amOnPage($this->model->getIndexUrl(false));
        $I->submitForm('form[action="/<?= Inflector::slug($modelClass) ?>/process-checkbox"]', [
            'process-selected' => 'active', 
            'selection' => [1]
        ]);
        $I->see('Confirm Action', 'h5');
    }
}
