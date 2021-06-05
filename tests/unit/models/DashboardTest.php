<?php

namespace tests\unit\models;

use app\models\User;
use app\models\search\DashboardSearch;

class DashboardTest extends \Codeception\Test\Unit
{
    public function testSearchWithResult()
    {
        $dashboardSearch = new DashboardSearch();
        $dataProviders = $dashboardSearch->search([
            'DashboardSearch' => ['keywords' => 'developer', 'modules' => ['UserSearch']]
        ]);

        expect_that($dataProviders);
    }

    public function testSearchWithNoResult()
    {
        $dashboardSearch = new DashboardSearch();
        $dataProviders = $dashboardSearch->search([
            'DashboardSearch' => ['keywords' => 'noresultsearch', 'modules' => ['UserSearch']]
        ]);

        expect_not($dataProviders);
    }
}
