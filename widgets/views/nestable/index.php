<?php

use app\helpers\Html;
use app\helpers\Url;
use app\helpers\App;


$this->addJsFile('js/jquery.nestable');
$this->registerWidgetCssFile('nestable');
$this->registerWidgetJsFile('nestable');

$this->registerJs(<<< JS
    new NestableWidget({
        widgetId: '{$widgetId}',
        defaultName: '{$defaultName}',
    }).init();
JS);


?>
<div id="<?= $widgetId ?>">
    <datalist id="link-list-<?= $widgetId ?>">
        <?= Html::foreach($controller_actions, function($actions, $controller) {
            return Html::foreach($actions, function($action) use ($controller) {
                return Html::tag('option', '', [
                    'value' => str_replace(App::baseUrl(), '', Url::toRoute(["{$controller}/{$action}"]))
                ]);
            });
        }) ?>
    </datalist>
    <div class="row">
        <div class="col-md-12">
            <menu id="nestable-menu-<?= $widgetId ?>" class="btn btn-group menu-nestable-menu">
                <a href="#!" class="btn btn-secondary btn-linkedin btn-sm" id="add-main-navigation-<?= $widgetId ?>">
                    Add Menu
                </a>
                <button class="btn btn-outline-secondary btn-sm" type="button" data-action="collapse-all">
                    <i class="fas fa-compress"></i> Collapse
                </button>
                <button class="btn btn-outline-secondary btn-sm" type="button" data-action="expand-all">
                    <i class="fas fa-expand"></i> Expand
                </button>
            </menu>
            <div class="dd" id="dd-<?= $widgetId ?>">
                <ol class="dd-list" id="ol-dd-list-<?= $widgetId ?>">
                    <?= $this->render('_navigation', [
                        'data_id' => [],
                        'navigations' => $navigations,
                        'widgetId' => $widgetId,
                    ]) ?>
                </ol>
            </div>
        </div>
    </div>
</div>