<?php

use app\helpers\App;
use app\models\search\SettingSearch;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\helpers\Html;

function menu($menus)
{
    foreach ($menus as &$menu) {
        $menu['url'] = $menu['link'];
        unset($menu['link']);
        if (isset($menu['sub'])) {
            $menu['items'] = menu($menu['sub']);
            unset($menu['sub']);
        }
    }
    return $menus;
}
$menus = menu($menus);

if (App::isGuest()) {
    $menus[] = ['label' => 'Login', 'url' => ['/site/login']];
}
else {
    $menus[] = '<li>'
        . Html::beginForm(['/site/logout'], 'post', ['style' => 'margin-top: 10px;'])
        . Html::submitButton(
            'Logout (' . App::identity('username') . '-' . App::identity('roleName') . ')',
            ['class' => 'btn btn-link logout']
        )
        . Html::endForm()
    . '</li>';
}

NavBar::begin([
    'brandLabel' => SettingSearch::default('app_name'),
    'brandUrl' => Yii::$app->homeUrl,
    'options' => [
        'class' => 'navbar-inverse navbar-fixed-top',
    ],
]);
echo Nav::widget([
    'options' => ['class' => 'navbar-nav navbar-right'],
    'items' => $menus,
]);
NavBar::end();
