<?php

use yii\helpers\Url;

?>
<div class="row">
    <div class="col-md-12">
        <datalist id="link-list">
            <?php foreach ($controller_actions as $controller => $actions) : ?>
                <?php foreach ($actions as $action) : ?>
                    <option value="<?= Url::to(["{$controller}/{$action}"]) ?>">
                    </option>
                <?php endforeach; ?>
            <?php endforeach; ?>
        </datalist>
        <a href="#!" onclick="addMainNavigation()" class="btn btn-secondary">
            Add Menu
        </a>
        <menu id="nestable-menu" class="btn btn-group pull-right">
          
            <button class="btn btn-secondary" 
                type="button" 
                data-action="collapse-all" onclick="collapseNavigation(this)">
                Toggle
            </button>
        </menu>
        <div class="dd">
            <ol class="dd-list" id="ol-dd-list">
                <?= $this->render('_navigation', [
                    'data_id' => [],
                    'navigations' => $model->main_navigation
                ]) ?>
            </ol>
        </div>
    </div>
</div>